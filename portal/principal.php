<!DOCTYPE HTML>
<!--
	Spatial by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>

<head>
	<title>Portal Maximus</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>

	<!-- Header -->
	<header id="header">
		<h1><strong><a href="index.html">Spatial</a></strong> by Templated</h1>
		<nav id="nav">
			<ul>
				<li><a href="../index.html">Início</a></li>
				<li><a href="usuarios.html">Usuários</a></li>
				<li><a href="materias.html">Materias</a></li>
				<li><a href="notas.html">Notas</a></li>
				<li><a href="ajuda.html">Ajuda</a></li>
			</ul>
		</nav>
	</header>

	<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>


	<!-- Main -->


	<!-- Two -->
	<section id="main" class="wrapper special">
		<div class="container">
			<header class="major">
				<!-- <h2>Área Segura</h2>
				<p>Faça a autenticação para obter acesso ao portal</p>
				<br>
				<form method="post">
					<p>Login:</p><input type="text" name="login" style="width:250px; margin:auto;">
					<p>Senha:</p> <input type="password" name="senha" style="width:250px; margin:auto;"><br>
					<p><input type="submit" value="Acessar" style="width:130px;"></p>
				</form> -->



        <?php
            // Conexão com o banco de dados
            require "conecta_db.php";

            // Inicia sessões
            session_start();

            echo "<p> ID do usuário: " .  $_SESSION["id_usuario"] . "</p>";
            echo "<p> Nome do usuário: " .  $_SESSION["nome_usuario"] . "</p>";
            echo "<p> Tipo de usuário: " .
                 ($_SESSION["ind_aluno"] === 'S' ? "Aluno" : ($_SESSION["ind_professor"] === 'S' ? "Professor" : "Secretaria" )) .
                  " </p>";


            // $_SESSION["nome_usuario"] = stripslashes($dados["nome"]);
            // $_SESSION["ind_aluno"]= $dados["ind_aluno"];
            // $_SESSION["ind_professor"]= $dados["ind_professor"];
            // $_SESSION["ind_secretaria"]= $dados["ind_secretaria"];



        ?>

      </header>




		</div>
	</section>




	<!-- Footer -->
	<footer id="footer">
		<div class="container">
			<ul class="icons">
				<li><a href="#" class="icon fa-facebook"></a></li>
				<li><a href="#" class="icon fa-twitter"></a></li>
				<li><a href="#" class="icon fa-instagram"></a></li>
			</ul>
			<ul class="copyright">
				<li>&copy; Untitled</li>
				<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
				<li>Images: <a href="http://unsplash.com">Unsplash</a></li>
			</ul>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>
