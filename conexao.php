<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "ger_projetos"; 

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Fecha a conexão com o banco de dados
//$conn->close();
?>

