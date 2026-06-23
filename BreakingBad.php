<?php
// Inclui o arquivo de cabeçalho do site
include __DIR__.'/includes/header.php';

// 1. Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/config/database.php'; 

if (!isset($pdo)) {
    if (isset($conn)) { $pdo = $conn; }
    elseif (isset($conexao)) { $pdo = $conexao; }
}

// 2. Define qual filme/série buscar
$filme_nome = 'Breaking Bad'; 

$mensagem_sucesso = "";
$mensagem_erro = "";

// aqui é a lógica para salvar o comentário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = trim($_POST['comentario']);
    if (empty($comentario)) {
        $mensagem_erro = "Por favor, digite um comentário.";
    } elseif (mb_strlen($comentario) > 100) {
        $mensagem_erro = "Erro: O comentário passou de 100 caracteres!";
    } else {
        try {
            $stmt_insert = $pdo->prepare("INSERT INTO comentarios (filme, usuario, comentario, data_envio) VALUES (:filme, :usuario, :comentario, NOW())");
            $stmt_insert->execute([
                'filme' => $filme_nome,
                'usuario' => 'Anônimo',
                'comentario' => $comentario
            ]);
            $mensagem_sucesso = "Comentário enviado com sucesso!";
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao salvar no banco de dados: " . $e->getMessage();
        }
    }
}

//buscar os comentários
try {
    $stmt = $pdo->prepare("SELECT usuario, comentario, data_envio FROM comentarios WHERE filme = :filme ORDER BY data_envio DESC");
    $stmt->execute(['filme' => $filme_nome]);
    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao carregar comentários: " . $e->getMessage();
    $comentarios = [];
}
?>

<div class="avaliacao-container">
    <div class="sidebar">
        <img src="https://m.media-amazon.com/images/M/MV5BMjhiMzgxZTctNDc1Ni00OTUxLTkwNTUtOTExMmU3M2U5Yjc1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Capa de Breaking Bad">
        <h2>Breaking Bad</h2>
        <p><strong>Ano de Lançamento:</strong> 2008</p>
        <p><strong>Criação:</strong> Vince Gilligan</p>
        <p><strong>Nota:</strong> 5 / 5</p>
    </div>

    <div class="main-content">
        <h3>Sinopse</h3>
        <p>Um professor de química do ensino médio diagnosticado com câncer pulmonar terminal se junta a um ex-aluno para fabricar e vender metanfetamina, buscando garantir o futuro financeiro de sua família.</p>
        
        <div class="comentarios-section">
            <hr>
            <h3>Comentários</h3>

            <?php if (!empty($mensagem_erro)): ?>
                <p style="color: red;"><?php echo $mensagem_erro; ?></p>
            <?php endif; ?>
            <?php if (!empty($mensagem_sucesso)): ?>
                <p style="color: green;"><?php echo $mensagem_sucesso; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="comentario">Seu comentário (máx. 100 caracteres):</label><br>
                <textarea id="comentario" name="comentario" rows="3" cols="50" maxlength="100" required></textarea><br><br>
                <button type="submit">Enviar Comentário</button>
            </form>

            <br><hr><br>

            <div class="lista-comentarios">
                <?php if (empty($comentarios)): ?>
                    <p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                <?php else: ?>
                    <?php foreach ($comentarios as $c): ?>
                        <div class="comentario-item" style="border-bottom: 1px solid #ddd; margin-bottom: 15px; padding-bottom: 10px;">
                            <strong><?php echo htmlspecialchars($c['usuario']); ?></strong> 
                            <small style="color: #777;"> em <?php echo date('d/m/Y H:i', strtotime($c['data_envio'])); ?></small>
                            <p style="margin-top: 5px;"><?php echo nl2br(htmlspecialchars($c['comentario'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__.'/includes/footer.php';
?>