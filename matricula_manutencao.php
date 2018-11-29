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
            <h2>Associação de Disciplina</h2>
            <p>Informe os dados para a matrícula.</p>
          </header>

  <?php
  if (!empty($_GET)) {
    $SQL = "SELECT m.id_matriculas, m.materias_id_materias, m.usuarios_id_usuarios, a.materia, t.turno,
            (select max(nome) from usuarios where id_usuarios = a.usuarios_id_usuarios) as professor ,
            u.nome as aluno FROM matriculas m
            inner join usuarios u on m.usuarios_id_usuarios = u.id_usuarios
            inner join materias a on m.materias_id_materias = a.id_materias
            left join turnos t on m.turnos_id_turnos = t.id_turnos
            WHERE m.id_matriculas = '" . $_GET['m'] . "'";
    $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
    $total = @mysqli_num_rows($result_id);
    // Caso o usuário tenha digitado um login válido o número de linhas será 1..
    if ($total) {
      $dados = @mysqli_fetch_array($result_id);

      $materia = $dados["materia"];
      $turno =  $dados["turno"];
      $aluno = $dados["usuarios_id_usuarios"];
      $id_matriculas = $dados["id_matriculas"];
    } else {
      $materia = "";
      $turno = "";
      $aluno = "";
      $id_matriculas = "";
      header('location:matricula_manutencao.php');
    }
  } else {
    $materia = "";
    $turno = "";
    $aluno = "";
    $id_matriculas = "";
  }
?>
          <!-- Form -->
            <section>
              <h3>Associar nova disciplina</h3>
              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">
                  <div class="12u$">

                    <div class="select-wrapper">
                      <select name="aluno" id="aluno">
                        <option value="">- Aluno -</option>
                        <?php
                        $SQL = "SELECT id_Usuarios , login , nome FROM usuarios WHERE ind_Aluno = 'S' order by nome";
                        $result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                        while ($row = mysqli_fetch_array($result)) {
                          echo "<option value=\"" . $row["id_Usuarios"] . "\"" .
                               (!empty($aluno) ? ($aluno == $row["id_Usuarios"] ? " selected=\"selected\"" : "") : "") .
                               "\">" . $row["nome"] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="12u$">
                    <div class="select-wrapper">
                      <select name="materia" id="materia">
                        <option value="">- Disciplina -</option>
                        <?php
                        $SQL = "SELECT id_materias , materia , descricao FROM materias order by materia";
                        $result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                        while ($row = mysqli_fetch_array($result)) {
                          echo "<option value=\"" . $row["id_materias"] . "\"" .
                               (!empty($materia) ? ($materia == $row["materia"] ? " selected=\"selected\"" : "") : "") .
                               "\">" . $row["materia"] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="12u$">
                    <div class="select-wrapper">
                      <select name="turno" id="turno">
                        <option value="">- Turno -</option>
                        <?php
                        $SQL = "SELECT id_turnos , turno , descricao FROM turnos order by turno";
                        $result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                        while ($row = mysqli_fetch_array($result)) {
                          echo "<option value=\"" . $row["id_turnos"] . "\"" .
                               (!empty($turno) ? ($turno == $row["turno"] ? " selected=\"selected\"" : "") : "") .
                               "\">" . $row["turno"] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="12u$">
                    <ul class="actions">
                      <?php
                      if (!empty($_GET)) {
                        if ($total) {
                          //echo "<li><input type=\"submit\" value=\"Alterar\" name=\"Alterar\" class=\"special\" /></li>";
                          echo "<li><input type=\"submit\" value=\"Excluir\" name=\"Excluir\" class=\"special\" /></li>";
                        } else {
                          echo "<li><input type=\"submit\" value=\"Incluir\" name=\"Incluir\" class=\"special\" /></li>";
                        }
                      } else {
                        echo "<li><input type=\"submit\" value=\"Incluir\" name=\"Incluir\" class=\"special\" /></li>";
                      }
                      echo "<li><input type=\"submit\" value=\"Voltar\" name=\"Voltar\" class=\"special\" /></li>";
                      ?>
                      <!-- <li><input type="reset" value="Limpar" /></li> -->
                    </ul>
                  </div>
                </div>
              </form>
            </section>
        </div>
      </section>

<?php
// Só entra aqui se for um postback
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Voltar'])) {
      header('location:matricula.php');
    }

  $materia = isset($_POST["materia"]) ? trim($_POST["materia"]) : FALSE;
  $aluno = isset($_POST["aluno"]) ? trim($_POST["aluno"]) : FALSE;
  $turno = isset($_POST["turno"]) ? trim($_POST["turno"]) : FALSE;

  if (isset($_POST['Incluir'])) {
    $SQL = "INSERT INTO matriculas (materias_id_materias, usuarios_id_usuarios, turnos_id_turnos) VALUES ('"
           . $materia . "', '" . $aluno . "', '" . $turno. "')";

    mysqli_query($conn, $SQL);
  } elseif (isset($_POST['Alterar'])) {

  } elseif (isset($_POST['Excluir'])) {
    $SQL =  "delete from matriculas where materias_id_materias = '". $materia . "' and usuarios_id_usuarios = '". $aluno . "'";
    mysqli_query($conn, $SQL);
  }

  header('location:matricula.php');
}
?>



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
