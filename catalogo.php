<?php
require_once 'config/database.php';

// Filtros
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';


// Consulta principal
// Consulta principal
$sql = "
SELECT * FROM (

    SELECT
        id_filme AS id,
        titulo,
        tipo,
        ano,
        genero,
        sinopse,
        capa,
        produtora_filme AS produtora
    FROM Filme

    UNION ALL

    SELECT
        id_serie AS id,
        titulo,
        tipo,
        ano,
        genero,
        sinopse,
        capa,
        produtora_serie AS produtora
    FROM Serie

) AS conteudos
WHERE 1=1
";


// Filtro por tipo
if ($tipo) {
    $sql .= " AND tipo = :tipo";
}


// Filtro por busca
if ($busca) {
    $sql .= " AND (titulo LIKE :busca OR genero LIKE :busca)";
}


// Ordem final
$sql .= " ORDER BY titulo ASC";


$stmt = $conn->prepare($sql);


if ($tipo) {
    $stmt->bindValue(':tipo', $tipo);
}

if ($busca) {
    $stmt->bindValue(':busca', "%$busca%");
}


$stmt->execute();

$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);


include __DIR__.'/includes/header.php';
?>

</head>
<body>
    <nav class="navbar">
        <div class="container nav">
            <a href="index.php" class="logo">Cine<span>Plus</span></a>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="catalogo.php" class="active">Catálogo</a>
                <a href="adicionar.php">Adicionar</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <h2 class="section-title">Catálogo Completo</h2>

        <form method="GET" class="form-busca">
            <input type="text" name="busca" placeholder="Buscar por título ou gênero..." value="<?= htmlspecialchars($busca) ?>">
            <button type="submit">Buscar</button>
        </form>

        <div class="filters">
            <a href="catalogo.php" class="<?= $tipo === '' ? 'active' : '' ?>">Todos</a>
            <a href="catalogo.php?tipo=filme" class="<?= $tipo === 'filme' ? 'active' : '' ?>">🎬 Filmes</a>
            <a href="catalogo.php?tipo=serie" class="<?= $tipo === 'serie' ? 'active' : '' ?>">📺 Séries</a>
        </div>

        <?php if(count($lista) > 0): ?>
        <div class="grid">
            <?php foreach($lista as $row): ?>
            <div class="card">
                <div class="card-img">
                    <?php if($row['capa']): ?>
                        <img src="<?= htmlspecialchars($row['capa']) ?>" alt="<?= htmlspecialchars($row['titulo']) ?>">
                    <?php else: ?>
                        🎬
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="card-type"><?= $row['tipo'] === 'filme' ? '🎬 Filme' : '📺 Série' ?></span>
                    <h3 class="card-title"><?= htmlspecialchars($row['titulo']) ?></h3>
                    <p class="card-info"><?= $row['ano'] ?> • <?= htmlspecialchars($row['genero']) ?></p>
                    <p class="card-info">
    <?= htmlspecialchars($row['produtora'] ?? '') ?>
</p>
                    <a href="avaliacao.php?id=<?= $row['id'] ?>" class="btn" style="margin-top:10px; display:block; text-align:center;">Ver Detalhes</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty">
            <p>Nenhum resultado encontrado.</p>
            <a href="adicionar.php" class="btn" style="margin-top:20px;">Adicionar conteúdo</a>
        </div>
        <?php endif; ?>
    </main>

</body>

<?php
    include __DIR__.'/includes/footer.php';
?>