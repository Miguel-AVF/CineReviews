<?php
session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: login.php");
    exit;
}


require_once 'config/database.php';

/*
    Busca os últimos filmes cadastrados
*/
$sql = "

SELECT *
FROM (

SELECT
id_filme AS id,
titulo,
tipo,
ano,
genero,
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
capa,
produtora_serie AS produtora
FROM Serie

) x

ORDER BY id DESC
LIMIT 8

";

$stmt = $conn->prepare($sql);
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
            <a href="index.php" class="active">Início</a>
            <a href="catalogo.php">Catálogo</a>
            <a href="adicionar.php">Adicionar</a>
            </div>
        </div>
    </nav>

    <div class="hero">
        <h1>Bem-vindo ao <span>CinePlus</span></h1>
        <p>Seu site de avaliações de filmes e séries</p>
        <a href="catalogo.php" class="btn">Ver Catálogo</a>
    </div>

    <main class="container">
        <h2 class="section-title">Últimos Adicionados</h2>
        
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
                    <p class="card-info"> <?= htmlspecialchars($row['produtora']) ?> </p>
                    <a href="avaliacao.php?id=<?= $row['id'] ?>" class="btn" style="margin-top:10px; display:block; text-align:center;">Ver Detalhes</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
<?php
include __DIR__.'/includes/footer.php';
?>