<?php

$servername_db = "localhost";
$username_db = "root";
$password_db = "";
$dbname_db = "maximus";

// Create connection
$conn = new mysqli($servername_db, $username_db, $password_db, $dbname_db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

  $SQL = "SELECT count(*) as c FROM usuarios ";
  $result = mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
  $row = mysqli_fetch_assoc($result);
  $total = $row['c'];
  // Caso o usuário tenha digitado um login válido o número de linhas será 1..
  if ($total == 0) {
  // se não tiver nenhum usuário , cria o usuário imagesetinterpolation
  mysqli_query($conn, "INSERT INTO usuarios (login, nome, senha, ind_Secretaria, ind_Aluno, ind_Professor, RA)" .
                          " VALUES ('master', 'Usuario Master', '" . md5('master') . "', 'S', 'N', 'N', null) ");
  }
}

// Inicia sessões
session_start();
?>
