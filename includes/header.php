<?php
$pageTitle = isset($pageTitle) ? $pageTitle : 'CinePlus';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #141414;
        color: #fff;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .navbar {
        background: #000;
        padding: 15px 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        color: #e50914;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }

    .logo span {
        color: #fff;
    }

    .nav-links a {
        color: #fff;
        text-decoration: none;
        margin-left: 20px;
        padding: 8px 15px;
        border-radius: 5px;
        transition: 0.3s;
    }

    .nav-links a:hover, .nav-links a.active {
        background: #e50914;
    }

    main {
        flex: 1;
        margin-top: 70px;
        padding: 30px 0;
    }

    .hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                    url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1200');
        background-size: cover;
        background-position: center;
        padding: 100px 20px;
        text-align: center;
        border-radius: 0 0 30px 30px;
        margin-bottom: 40px;
    }

    .hero h1 {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .hero h1 span {
        color: #e50914;
    }

    .hero p {
        font-size: 18px;
        color: #ccc;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-block;
        padding: 12px 30px;
        background: #e50914;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        background: #b2070f;
        transform: scale(1.05);
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .card {
        background: #1f1f1f;
        border-radius: 10px;
        overflow: hidden;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(229, 9, 20, 0.3);
    }

    .card-img {
        height: 350px;
        background: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }

    .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
    }

    .card-type {
        display: inline-block;
        padding: 3px 10px;
        background: #e50914;
        border-radius: 3px;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card-info {
        color: #888;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .card-nota {
        font-size: 24px;
        color: #ffd700;
        font-weight: bold;
    }

    .section-title {
        font-size: 28px;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e50914;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #ccc;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
        width: 100%;
        padding: 12px;
        background: #1f1f1f;
        border: 1px solid #333;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #e50914;
    }

    .form-group textarea {
        min-height: 150px;
        resize: vertical;
    }

    .btn-submit {
        width: 100%;
        padding: 15px;
        background: #e50914;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #b2070f;
    }

    .avaliacao-card {
        background: #1f1f1f;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .avaliacao-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .avaliacao-nota {
        color: #ffd700;
        font-size: 20px;
    }

    .avaliacao-body {
        color: #ccc;
        line-height: 1.6;
    }

    .form-busca {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .form-busca input {
        flex: 1;
        padding: 12px;
        background: #1f1f1f;
        border: 1px solid #333;
        border-radius: 5px;
        color: #fff;
    }

    .form-busca button {
        padding: 12px 25px;
        background: #e50914;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .footer {
        background: #000;
        padding: 30px 0;
        text-align: center;
        margin-top: auto;
    }

    .footer p {
        color: #666;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filters a {
        padding: 8px 20px;
        background: #1f1f1f;
        color: #fff;
        text-decoration: none;
        border-radius: 20px;
        transition: 0.3s;
    }

    .filters a:hover, .filters a.active {
        background: #e50914;
    }

    .msg {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .msg-success {
        background: #1a4f1a;
        color: #4caf50;
    }

    .msg-error {
        background: #4f1a1a;
        color: #f44336;
    }

    .empty {
        text-align: center;
        padding: 50px;
        color: #666;
    }

    .detalhe-card {
        display: flex;
        gap: 30px;
        background: #1f1f1f;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 40px;
    }

    .detalhe-img {
        width: 300px;
        height: 450px;
        background: #333;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .detalhe-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detalhe-body {
        flex: 1;
    }

    .detalhe-body h1 {
        font-size: 36px;
        margin: 10px 0;
    }

    .avaliacao-form {
        background: #1f1f1f;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .avaliacoes-list {
        margin-top: 30px;
    }

    .form-content {
        max-width: 600px;
        background: #1f1f1f;
        padding: 30px;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .detalhe-card {
            flex-direction: column;
        }

        .detalhe-img {
            width: 100%;
            height: 300px;
        }

        .nav {
            flex-direction: column;
            gap: 15px;
        }

        .nav-links {
            margin-top: 15px;
        }

        .nav-links a {
            margin-left: 0;
            margin: 0 5px;
        }
    }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container nav">
            <a href="index.php" class="logo">Cine<span>Plus</span></a>
            <div class="nav-links">
                <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Início</a>
                <a href="catalogo.php" class="<?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">Catálogo</a>
                <a href="adicionar.php" class="<?= basename($_SERVER['PHP_SELF']) == 'adicionar.php' ? 'active' : '' ?>">Adicionar</a>
            </div>
        </div>
    </nav>

    <main>