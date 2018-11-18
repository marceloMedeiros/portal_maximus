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
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>
	<!-- Header -->
	<header id="header">
		<h1><strong><a href="index.html">Spatial</a></strong> by Templated</h1>
		<nav id="nav">
			<ul>
				<li><a href="index.html">Início</a></li>
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
				<h2>Área Segura</h2>
				<p>Faça a autenticação para obter acesso ao portal</p>
				<br>
				<form method="post" accept-charset="utf-8">
					<p>Login:</p><input type="text" name="login" style="width:250px; margin:auto;">
					<p>Senha:</p> <input type="password" name="senha" style="width:250px; margin:auto;"><br>
					<p><input type="submit" value="Acessar" style="width:130px;"></p>
				</form>
        <?php
// Conexão com o banco de dados
require "portal/conecta_db.php";
// Inicia sessões
/**
 * Verifica se o usuário já está logado
 */
if (isset($_SESSION['id_usuario'])) {
    header("Location: principal.php");
    exit;
}
// Só entra aqui se for um postback
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atribui a uma variável o login digitado pelo usuário
    $login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
    // Atribui a uma variável a senha digitado pelo usuário a, criptografando em MD5
    $senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
    // echo $senha . "<br>";
    // Usuário não forneceu a senha ou o login
    if (!$login || !$senha) {
        echo "Você deve digitar sua senha e login!";
        exit;
    }
    /**
     * Executa a consulta no banco de dados.
     * Caso o número de linhas retornadas seja 1 o login é válido,
     * caso 0, inválido.
     */
    $SQL = "SELECT id_usuarios , login , senha , nome , ra , ind_Aluno , ind_Professor , ind_Secretaria FROM usuarios WHERE login = '" . $login . "'";
    $result_id = @mysql_query($SQL) or die("Erro no banco de dados!");
    $total = @mysql_num_rows($result_id);
    // Caso o usuário tenha digitado um login válido o número de linhas será 1..
    if ($total) {
        // Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão
        $dados = @mysql_fetch_array($result_id);
        // Agora verifica a senha
        if (!strcmp($senha, $dados["senha"])) {
            // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
            $_SESSION["id_usuario"]     = $dados["id_usuarios"];
            $_SESSION["nome_usuario"]   = stripslashes(utf8_decode($dados["nome"]));
            $_SESSION["ind_aluno"]      = $dados["ind_Aluno"];
            $_SESSION["ind_professor"]  = $dados["ind_Professor"];
            $_SESSION["ind_secretaria"] = $dados["ind_Secretaria"];
            header("Location: principal.php");
            //echo print_r($dados);
            exit;
        }
        // Senha inválida
        else {
            echo "Senha inválida!";
            exit;
        }
    }
    // Login inválido
    else {
        echo "O login fornecido por você é inexistente!";
        exit;
    }
}
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
