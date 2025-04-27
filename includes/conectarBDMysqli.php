<?php 

$nomeServidor = "localhost";
$usuario = "root";
$senha = '';
$dbName = "pacientes";

$conexao = mysqli_connect("localhost", "root", "", "pacientes");

if(!$conexao){
    die ("<pre>" . "Não foi possível conectar ao banco de dados. Entre em contato com o Administrador. ERROR " . mysqli_connect_error());
}

?>