<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: catalogo.php");
    exit;
}

$id = (int)$_GET['id'];

$sql = "
SELECT *
FROM Filme
WHERE id_filme = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();

$conteudo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conteudo) {
    header("Location: catalogo.php");
    exit;
}

$msg = '';

$logado = isset($_SESSION['id_user']);

if (isset($_POST['enviar_avaliacao'])) {

    $comentario = trim($_POST['comentario']);

    if (!empty($comentario)) {

        $sql = "
        INSERT INTO Comentario
        (id_user, id_filme, decric_coment)
        VALUES
        (:id_user, :id_filme, :comentario)
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id_user', $_SESSION['id_user']);
        $stmt->bindValue(':id_filme', $id);
        $stmt->bindValue(':comentario', $comentario);

        if($stmt->execute()){
            $msg = "Comentário enviado!";
        }
    }
}

$sqlComentarios = "
SELECT c.decric_coment,
       u.nome_user
FROM Comentario c
INNER JOIN usuarios u
ON u.id_user = c.id_user
WHERE c.id_filme = :id
ORDER BY c.id_coment DESC
";

$stmtComentarios = $conn->prepare($sqlComentarios);
$stmtComentarios->bindValue(':id',$id);
$stmtComentarios->execute();

$comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);

include __DIR__.'/includes/header.php';
?>

<hr>

<h3>Comentários</h3>

<?php foreach($comentarios as $coment): ?>

<div class="card" style="margin-top:15px;">
    <div class="card-body">

        <strong>
            <?= htmlspecialchars($coment['nome_user']) ?>
        </strong>

        <p>
            <?= htmlspecialchars($coment['decric_coment']) ?>
        </p>

    </div>
</div>

<?php endforeach; ?>

<main class="container">

<h2 class="section-title">
    <?= htmlspecialchars($conteudo['titulo']) ?>
</h2>

<div class="card" style="max-width:800px;margin:auto;">

    <div class="card-body">

        <p>
            <strong>Produtora:</strong>
            <?= htmlspecialchars($conteudo['produtora_filme']) ?>
        </p>

        <p>
            <strong>Gênero:</strong>
            <?= htmlspecialchars($conteudo['genero']) ?>
        </p>

        <p>
            <strong>Ano:</strong>
            <?= $conteudo['ano'] ?>
        </p>

        <hr>

        <h3>Sinopse</h3>

        <p>
            <?= nl2br(htmlspecialchars($conteudo['sinopse'])) ?>
        </p>

    </div>

</div>

<br>

<div class="card" style="max-width:800px;margin:auto;">
    <div class="card-body">

        <h3>Deixe um comentário</h3>

        <?php if($msg): ?>
            <p><?= $msg ?></p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <input
                    type="text"
                    name="nome"
                    placeholder="Seu nome"
                    required
                >
            </div>

            <div class="form-group">
                <textarea
                    name="comentario"
                    rows="5"
                    required
                    placeholder="Digite seu comentário"
                ></textarea>
            </div>

            <button
                type="submit"
                name="enviar_avaliacao"
                class="btn"
            >
                Enviar Comentário
            </button>

        </form>

    </div>
</div>

</main>

</body>

<?php
    include __DIR__.'/includes/footer.php';
?>