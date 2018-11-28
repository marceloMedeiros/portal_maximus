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
            <h2>Cadastro de Disciplinas</h2>
            <p>Informe os dados da disciplina.</p>
          </header>

  <?php
  if (!empty($_GET)) {
    $SQL = "SELECT materia , descricao , usuarios_id_usuarios FROM materias WHERE materia = '" . $_GET['m'] . "'";
    $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
    $total = @mysqli_num_rows($result_id);
    // Caso o usuário tenha digitado um login válido o número de linhas será 1..
    if ($total) {
      $dados = @mysqli_fetch_array($result_id);

      $materia = $dados["materia"];
      $descricao = $dados["descricao"];
      $usuarios_id_usuarios = $dados["usuarios_id_usuarios"];
    } else {
      $materia = "";
      $descricao = "";
      $usuarios_id_usuarios = "";
      header('location:materias_manutencao.php');
    }
  } else {
    $materia = "";
    $descricao = "";
    $usuarios_id_usuarios = "";
  }
?>
          <!-- Form -->
            <section>
              <?php
              if ($materia != ""){
                  echo("<h3>Alterar dados da disciplina</h3>");
              } else {
                  echo("<h3>Cadastrar nova disciplina</h3>");
              }
              ?>
              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)">
                  Nome da disciplina: <input type="text" name="materia" id="materia" value="<?php echo $materia; ?>" placeholder="Nome da disciplina" />
                  </div>
                  <div class="6u$ 12u$(xsmall)">
                  Descrição da disciplina: <input type="text" name="descricao" id="descricao" value="<?php echo $descricao; ?>" placeholder="Descrição da disciplina" />
                  </div>
                  <div class="12u$">
                    <div class="select-wrapper">
                    Professor responsável:
                    <select name="professor" id="professor">
                        <option value="">- Professor -</option>
                        <?php
                        $SQL = "SELECT id_Usuarios , login , nome FROM usuarios WHERE ind_Professor = 'S' order by nome";
                        $result = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                        while ($row = mysqli_fetch_array($result)) {
                          echo "<option value=\"" . $row["id_Usuarios"] . "\"" .
                               (!empty($usuarios_id_usuarios) ? ($usuarios_id_usuarios == $row["id_Usuarios"] ? " selected=\"selected\"" : "") : "") .
                               "\">" . $row["nome"] . "</option>";
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
                          echo "<li><input type=\"submit\" value=\"Alterar\" name=\"Alterar\" class=\"special\" /></li>";
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
      header('location:usuarios.php');
    }

  $materia = isset($_POST["materia"]) ? addslashes(trim($_POST["materia"])) : FALSE;
  $descricao = isset($_POST["descricao"]) ? addslashes(trim($_POST["descricao"])) : FALSE;
  $usuarios_id_usuarios = isset($_POST["professor"]) ? trim($_POST["professor"]) : FALSE;


  if (isset($_POST['Incluir'])) {
    //echo "INSERT INTO materias (materia, descricao, usuarios_id_usuarios)" .
    //            " VALUES ('". $materia . "', '" . $descricao . "', '" . $usuarios_id_usuarios . "') ";
    mysqli_query($conn, "INSERT INTO materias (materia, descricao, usuarios_id_usuarios)" .
                " VALUES ('". $materia . "', '" . $descricao . "', '" . $usuarios_id_usuarios . "') ");
  } elseif (isset($_POST['Alterar'])) {
    mysqli_query($conn, "update materias set materia  = '" .  $materia . "'," .
                "                    descricao  = '" .  $descricao . "'," .
                "                    usuarios_id_usuarios  = '" .  $usuarios_id_usuarios . "' " .
                " where materia = '". $materia . "'");
  } elseif (isset($_POST['Excluir'])) {
    mysqli_query($conn, "delete from materias where materia = '". $materia . "'");
  }

  header('location:materias.php');
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
