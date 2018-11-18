<?php
// Conecta-se com o MySQL
mysql_connect("localhost", "root", "usbw");
// Seleciona banco de dados
mysql_select_db("maximus");
mysql_set_charset('utf8');

// Inicia sessões
session_start();
?>
