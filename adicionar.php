<?php
require_once 'config/database.php';

$msg = '';

if (isset($_POST['enviar'])) {

    $titulo = trim($_POST['titulo']);
    $produtora = trim($_POST['produtora']);
    $tipo = $_POST['tipo'];
    $ano = (int)$_POST['ano'];
    $genero = trim($_POST['genero']);
    $sinopse = trim($_POST['sinopse']);
    $capa = trim($_POST['capa']);


    if ($titulo && $produtora && $tipo && $ano && $genero) {


        if ($tipo == 'filme') {


            $sql = "INSERT INTO Filme
            (nome_filme, produtora_filme, titulo, tipo, ano, genero, sinopse, capa)

            VALUES

            (:nome_filme, :produtora_filme, :titulo, :tipo, :ano, :genero, :sinopse, :capa)";


            $stmt = $conn->prepare($sql);


            $stmt->bindValue(':nome_filme', $titulo);
            $stmt->bindValue(':produtora_filme', $produtora);


        } else if ($tipo == 'serie') {


            $sql = "INSERT INTO Serie
            (nome_serie, produtora_serie, titulo, tipo, ano, genero, sinopse, capa)

            VALUES

            (:nome_serie, :produtora_serie, :titulo, :tipo, :ano, :genero, :sinopse, :capa)";


            $stmt = $conn->prepare($sql);


            $stmt->bindValue(':nome_serie', $titulo);
            $stmt->bindValue(':produtora_serie', $produtora);

        }


        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':tipo', $tipo);
        $stmt->bindValue(':ano', $ano);
        $stmt->bindValue(':genero', $genero);

        // evita erro de sinopse grande
        $stmt->bindValue(':sinopse', substr($sinopse, 0, 400));

        $stmt->bindValue(':capa', $capa);



        if ($stmt->execute()) {

            header("Location: catalogo.php");
            exit;



        } else {

            $msg = 'error';

        }


    } else {

        $msg = 'error';

    }

}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinePlus - Adicionar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="container">
            <div class="nav">
                <a href="index.php" class="logo">Cine<span>Plus</span></a>
                <div class="nav-links">
                    <a href="index.php">Início</a>
                    <a href="catalogo.php">Catálogo</a>
                    <a href="adicionar.php" class="active">Adicionar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main -->
    <main>
        <div class="container">
            <h1 class="page-title">Adicionar <span>Conteúdo</span></h1>
            <p class="page-subtitle">Adicione novos filmes ou séries ao catálogo</p>

            <?php if($msg === 'success'): ?>
            <div class="alert alert-success">
                ✅ Conteúdo adicionado com sucesso! <a href="catalogo.php">Ver catálogo</a>
            </div>
            <?php elseif($msg === 'error'): ?>
            <div class="alert alert-error">
                ❌ Erro ao adicionar. Preencha todos os campos obrigatórios.
            </div>
            <?php endif; ?>

            <div class="form-wrapper">
                <!-- Formulário -->
                <div class="form-box">
                    <div class="form-icon">🎬</div>
                    <h2>Novo Filme ou Série</h2>

                    <form method="POST">
                        <div class="form-group">
                            <label>Título <span class="required">*</span></label>
                            <input type="text" name="titulo" required placeholder="Ex: O Poderoso Chefão">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Tipo <span class="required">*</span></label>
                                <select name="tipo" required>
                                    <option value="">Selecione...</option>
                                    <option value="filme">🎬 Filme</option>
                                    <option value="serie">📺 Série</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ano <span class="required">*</span></label>
                                <input type="number" name="ano" required placeholder="2024" min="1900" max="2030">
                            </div>
                        </div>

                         <div class="form-group">
                            <label>Diretor</label>
                            <input type="text" name="produtora" placeholder="Albert Ainsten">
                        </div>

                        <div class="form-group">
                            <label>Gênero <span class="required">*</span></label>
                            <input type="text" name="genero" required placeholder="Ex: Drama, Ação...">
                        </div>

                        <div class="form-group">
                            <label>Sinopse</label>
                            <textarea name="sinopse" placeholder="Resumo da história..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>URL da Capa</label>
                            <input type="url" name="capa" placeholder="https://exemplo.com/capa.jpg">
                        </div>

                        <button type="submit" name="enviar" class="btn-primary">
                            ➕ Adicionar ao Catálogo
                        </button>
                    </form>
                </div>

                <!-- Card de dicas -->
                <div class="info-box">
                    <h3><span>💡</span> Dicas</h3>
                    <ul class="info-list">
                        <li>🎥 Use capas de alta qualidade</li>
                        <li>📅 O ano de lançamento oficial</li>
                        <li>🏷️ Escolha o gênero correto</li>
                        <li>⭐ A nota será calculada</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

<?php
include __DIR__.'/includes/footer.php';
?>