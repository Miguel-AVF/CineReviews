<?php
require_once 'config/database.php';

$msg = '';

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $tel = $_POST['telefone'];

    $sql = "INSERT INTO usuarios
    (nome_user, login_user, senha_user, data_nasc_user, email_user, tel_user)
    VALUES
    (:nome,:login,:senha,:data,:email,:tel)";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':nome',$nome);
    $stmt->bindValue(':login',$login);
    $stmt->bindValue(':senha',$senha);
    $stmt->bindValue(':data',$data);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':tel',$tel);

    if($stmt->execute()){
        $msg = "Cadastro realizado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<div class="auth-box">

<h1>Cadastro</h1>

<?php if(!empty($msg)): ?>
<div class="mensagem">
    <?= $msg ?>
</div>
<?php endif; ?>

<form method="POST">

<input type="text" name="nome" placeholder="Nome Completo" required>

<input type="text" name="login" placeholder="Usuário" required>

<input type="password" name="senha" placeholder="Senha" required>

<input type="email" name="email" placeholder="Email" required>

<input type="date" name="data" required>

<input type="text" name="telefone" placeholder="Telefone">

<button type="submit" name="cadastrar">
Cadastrar
</button>

</form>

<a href="login.php">
Já tenho conta
</a>

</div>

</div>

<?php
    include __DIR__.'/includes/footer.php';
?>