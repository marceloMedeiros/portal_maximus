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
// define pagina para acesso a secretaria
$_SESSION["acesso"] = ["ind_secretaria"];
// Carrega o Menu de navegação
require "portal/menu.php";
?>
    <!-- Main -->
      <section id="main" class="wrapper">
        <div class="container">
          <header class="major special">
            <h2>Cadastro de Usuários</h2>
            <p>Consulta a usuários cadastrados.</p>
          </header>
          <!-- Table -->
            <section>
              <h3>Usuários cadastrados</h3>
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Login</th>
                      <th>Nome Completo</th>
                      <!-- <th>RA</th> -->
                      <th>Acesso</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
$SQL = "SELECT login , nome , ra , ind_Aluno , ind_Professor , ind_Secretaria FROM usuarios
        order by nome ";
$result = @mysql_query($SQL) or die("Erro no banco de dados!");
while ($row = mysql_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . "<a href=\"usuarios_manutencao.php?l=" . $row['login'] . "\">" .
  $row['login'] . "</a></td>";
  echo "<td>" . $row['nome'] . "</td>";
  // echo "<td>" . $row['ra'] . "</td>";
  if ($row['ind_Aluno'] === 'S'){
    echo "<td>Aluno</td>";
  } elseif ($row['ind_Professor'] === 'S'){
    echo "<td>Professor</td>";
  } elseif ($row['ind_Secretaria'] === 'S'){
    echo "<td>Secretaria</td>";
  }
  echo "</tr>";
}
?>
                  </tbody>
                </table>
              </div>
            </section>
            <!-- Buttons -->
            <section>
              <ul class="actions">
                  <li><a href="usuarios_manutencao.php" class="button special">Novo usuário</a></li>
              </ul>
            </section>
        </div>
      </section>
    <?php
// Carrega o Menu de navegação
require "portal/footer.php";
?>
            <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>
</body>
</html>
