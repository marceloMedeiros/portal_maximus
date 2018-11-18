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
            <h2>Cadastro de Matérias</h2>
            <p>Consulta a matérias cadastradas.</p>
          </header>
          <!-- Table -->
            <section>
              <h3>Matérias cadastrados</h3>
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Descrição</th>
                      <th>Matéria</th>
                      <th>Professor</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
$SQL = "SELECT materia , descricao , u.nome as professor FROM materias m
        inner join usuarios u on m.usuarios_id_usuarios = u.id_usuarios order by materia ";
$result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
while ($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['descricao'] . "</td>";
  echo "<td>" . "<a href=\"materias_manutencao.php?m=" . $row['materia'] . "\">" .
  $row['materia'] . "</a></td>";
  echo "<td>" . $row['professor'] . "</td>";
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
                  <li><a href="materias_manutencao.php" class="button special">Nova Matéria</a></li>
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
