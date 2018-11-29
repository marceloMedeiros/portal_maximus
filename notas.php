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
$_SESSION["acesso"] = ["ind_aluno" ,"ind_professor"];
// Carrega o Menu de navegação
require "portal/menu.php";
?>
    <!-- Main -->
      <section id="main" class="wrapper">
        <div class="container">
          <header class="major special">
<?php
  if (in_array("ind_aluno", $_SESSION["acesso"])){
    echo "<h2>Frequência e Notas</h2>
          <p>Consulta a frequência e notas.</p>";
  } elseif (in_array("ind_professor", $_SESSION["acesso"])){
    echo "<h2>Frequência e Notas de Alunos</h2>
          <p>Consulta a frequência e notas.</p>";
  }
?>
          </header>
          <!-- Table -->
            <section>
              <h3>Matrículas cadastradas</h3>
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Aluno</th>
                      <th>Professor</th>
                      <th>Matéria</th>
                      <th>Nota</th>
                      <th>Presenças</th>
                      <th>Faltas</th>
                      <th>Ativo</th>
                      <th>Aprovado</th>
                      <th>Reprovado</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
$SQL = "SELECT a.materia , (select max(nome) from usuarios where id_usuarios = a.usuarios_id_usuarios) as professor ,
        u.nome as aluno, m.nota, m.presencas, m.faltas, m.ind_ativo, m.ind_revisao, m.ind_revisado,
        m.ind_aprovacao, m.ind_reprovacao, m.id_matriculas  FROM matriculas m
        inner join usuarios u on m.usuarios_id_usuarios = u.id_usuarios
        inner join materias a on m.materias_id_materias = a.id_materias" .
        ($_SESSION["ind_aluno"] == 'S' ? " where m.usuarios_id_usuarios ='" . $_SESSION["id_usuario"] . "' " : "") .
        ($_SESSION["ind_professor"] == 'S' ? " where a.usuarios_id_usuarios ='" . $_SESSION["id_usuario"] . "' " : "") .
        "order by materia ";
        //echo $SQL;
$result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
while ($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  if ($_SESSION["ind_professor"] == 'S'){
    echo "<td>" . "<a href=\"notas_manutencao.php?m=" . $row['id_matriculas'] . "\">" .
    $row['aluno'] . "</a></td>";
  } else {
    echo "<td>" . $row['aluno'] . "</td>";
  }
  echo "<td>" . $row['professor'] . "</td>";
  echo "<td>" . $row['materia'] . "</td>";
  echo "<td>" . $row['nota'] . "</td>";
  echo "<td>" . $row['presencas'] . "</td>";
  echo "<td>" . $row['faltas'] . "</td>";
  echo "<td style=\" text-align: center; vertical-align: middle;\"> <input type=\"checkbox\" disabled name=\"nota\" id=\"nota\" style=\"opacity:100; -moz-appearance: checkbox; -webkit-appearance: checkbox; clear:both;\" " . ($row['ind_ativo'] == 'S' ? "checked" : "") . "/> </td>";
  echo "<td style=\" text-align: center; vertical-align: middle;\"> <input type=\"checkbox\" disabled name=\"nota\" id=\"nota\" style=\"opacity:100; -moz-appearance: checkbox; -webkit-appearance: checkbox; clear:both;\" " . ($row['ind_aprovacao'] == 'S' ? "checked" : "") . "/> </td>";
  echo "<td style=\" text-align: center; vertical-align: middle;\"> <input type=\"checkbox\" disabled name=\"nota\" id=\"nota\" style=\"opacity:100; -moz-appearance: checkbox; -webkit-appearance: checkbox; clear:both;\" " . ($row['ind_reprovacao'] == 'S' ? "checked" : "") . "/> </td>";
  echo "</tr>";
}
?>
                  </tbody>
                </table>
              </div>
            </section>
            <!-- Buttons -->

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
