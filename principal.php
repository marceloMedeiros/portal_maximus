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
  <?php
    // Conexão com o banco de dados
    require "portal/conecta_db.php";
    // Carrega o Menu de navegação
    require "portal/menu.php";
    ?>
    <!-- Main -->
      <section id="main" class="wrapper">
        <div class="container">

          <header class="major special">
            <h2>Área Segura</h2>
            <p>Seleciona a funcinalidade desejada no menu.</p>
          </header>

          <a href="#" class="image fit"><img src="assets/maximus/bg_maximus3.gif" alt="" /></a>
          <!-- <p></p> -->

        </div>
      </section>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <!-- <ul class="icons">
                <li><a href="#" class="icon fa-facebook"></a></li>
                <li><a href="#" class="icon fa-twitter"></a></li>
                <li><a href="#" class="icon fa-instagram"></a></li>
            </ul> -->



            <?php
              echo "<small>";
              //  echo "ID do usuário: "   . $_SESSION["id_usuario"]   . "";
              echo " Usuário: " . $_SESSION["nome_usuario"] . " - ";
              echo " Acesso: " . ($_SESSION["ind_aluno"] === 'S' ? "Aluno" : ($_SESSION["ind_professor"] === 'S' ? "Professor" : "Secretaria")) . "";
              echo "</small>";
            ?>



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
