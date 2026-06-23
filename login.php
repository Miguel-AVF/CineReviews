<?php
session_start();
require_once 'config/database.php';

$msg = '';

if(isset($_POST['entrar'])){

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios
            WHERE login_user = :login
            AND senha_user = :senha";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':login',$login);
    $stmt->bindValue(':senha',$senha);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nome_user'] = $user['nome_user'];

        header("Location: index.php");
        exit;

    }else{

        $msg = "Login inválido";

    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<div class="auth-box">

<h1>Login</h1>

<?php if(!empty($msg)): ?>
<div class="erro">
    <?= $msg ?>
</div>
<?php endif; ?>

<form method="POST">

<input
type="text"
name="login"
placeholder="Usuário"
required
>

<input
type="password"
name="senha"
placeholder="Senha"
required
>

<button type="submit" name="entrar">
Entrar
</button>

</form>

<a href="cadastro.php">
Criar conta
</a>

</div>

</div>
<?php
include __DIR__.'/includes/footer.php';
?>