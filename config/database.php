<?php
//Variáveis de conexão
$host="localhost";
$user="root";
$password="root";
$port=3306;
$database="Site_Avaliacao";

//Módulo PDO do PHP
try{
//instância a classe PDO
$conn=new PDO('mysql:host='.$host.';port='.$port.';dbname='.$database,$user,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'ERRO:  '.$e->getMessage();
}
?>