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
    <link rel="stylesheet" href="assets/css/popup.css" />
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
            <p>Informe os dados do usuário.</p>
          </header>

  <?php
  if (!empty($_GET)) {
    $SQL = "SELECT id_usuarios , login , senha , nome , ra , ind_Aluno , ind_Professor , ind_Secretaria FROM usuarios WHERE id_usuarios = '" . $_GET['l'] . "'";
    $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
    $total = @mysqli_num_rows($result_id);
    // Caso o usuário tenha digitado um login válido o número de linhas será 1..
    if ($total) {
      $dados = @mysqli_fetch_array($result_id);

      $id_usuarios = $dados["id_usuarios"];
      $login = $dados["login"];
      $nome = $dados["nome"];
      $senha = $dados["senha"];
      $ind_Secretaria = $dados["ind_Secretaria"];
      $ind_Aluno = $dados["ind_Aluno"];
      $ind_Professor = $dados["ind_Professor"];
      $RA = $dados["ra"];
    } else {
      $id_usuarios = "";
      $login = "";
      $nome = "";
      $senha = "";
      $ind_Secretaria = "";
      $ind_Aluno = "";
      $ind_Professor = "";
      $RA = "";
      header('location:usuarios_manutencao.php');
      exit();
    }
  } else {
    $id_usuarios = "";
    $login = "";
    $nome = "";
    $senha = "";
    $ind_Secretaria = "";
    $ind_Aluno = "";
    $ind_Professor = "";
    $RA = "";
  }
?>
          <!-- Form -->
            <section>
              <?php
              //testa se é um cadastro de novo usuário, ou manutenção de existente
              if ($login != ""){
                  echo("<h3>Alterar dados do usuário</h3>");
              } else {
                  echo("<h3>Cadastrar novo usuário</h3>");
              }
              ?>


              <?php
              // Só entra aqui se for um postback
              if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['Voltar'])) {
                  header('location:usuarios.php');
                } elseif (isset($_POST['Senha'])) {
                  header('location:senha.php?l=' . $_POST["id_usuarios"]);
                }

                $id_usuarios = isset($_POST["id_usuarios"]) ? addslashes(trim($_POST["id_usuarios"])) : FALSE;
                $login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
                $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : FALSE;
                $senha_ori = isset($_POST["senha"]) ? trim($_POST["senha"]) : FALSE;
                $senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
                $senha_r = isset($_POST["senha-r"]) ? md5(trim($_POST["senha-r"])) : FALSE;
                $ind_Secretaria = isset($_POST["acesso"]) ? ($_POST["acesso"] == 'ind_Secretaria' ? 'S' : 'N') : FALSE;
                $ind_Aluno = isset($_POST["acesso"]) ? ($_POST["acesso"] == 'ind_Aluno' ? 'S' : 'N') : FALSE;
                $ind_Professor = isset($_POST["acesso"]) ? ($_POST["acesso"] == 'ind_Professor' ? 'S' : 'N') : FALSE;
                $RA = isset($_POST["ra"]) ? addslashes(trim($_POST["ra"])) : FALSE;

                if ($senha != $senha_r){
                  echo "<div style=\"text-align:center; color:red;\">As senhas informadas não coincidem!</div><br/>";
                } elseif ($login == "" || $nome == ""){
                  echo "<div style=\"text-align:center; color:red;\">É necessário informar todos os campos!</div><br/>";
                } else {
                  if (isset($_POST['Incluir'])) {
                    if (strlen($senha_ori) < 5){
                      echo "<div style=\"text-align:center; color:red;\">Senha deve ter ao menos 5 caracteres!</div><br/>";
                    } else {
                      // primeiro testa se não existe um registro já com essa chave
                      $SQL = " select nome from usuarios
                               where login = '" . $login . "' ";
                      $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                      $total = @mysqli_num_rows($result_id);
                      // Caso o usuário tenha digitado um login válido o número de linhas será 1..
                      if ($total > 0) {
                          echo "<div style=\"text-align:center; color:red;\">Este nome de usuário (login) já está em uso!</div><br/>";
                      } else {
                        mysqli_query($conn, "INSERT INTO usuarios (login, nome, senha, ind_Secretaria, ind_Aluno, ind_Professor, RA)" .
                                " VALUES ('". $login . "', '" . $nome . "', '" . $senha . "', '" . $ind_Secretaria . "', '" . $ind_Aluno . "', '" . $ind_Professor . "', '" . $RA . "') ");
                        header('location:usuarios.php');
                        exit();
                      }
                    }
                  } elseif (isset($_POST['Alterar'])) {
                    mysqli_query($conn, "update usuarios set nome  = '" .  $nome . "'," .
                                "                    senha  = '" .  $senha . "'," .
                                "                    ind_Secretaria  = '" .  $ind_Secretaria . "'," .
                                "                    ind_Aluno  = '" .  $ind_Aluno . "'," .
                                "                    ind_Professor  = '" .  $ind_Professor . "'," .
                                "                    ra  = '" .  $RA . "' " .
                                " where id_usuarios = '". $id_usuarios . "'");
                    header('location:usuarios.php');
                    exit();
                  } elseif (isset($_POST['Excluir'])) {
                    mysqli_query($conn, "delete from usuarios where id_usuarios = '". $id_usuarios . "'");
                    header('location:usuarios.php');
                    exit();
                  }
                }

              }
              ?>


              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)">
                    Login:  <input type="text" name="login" id="login" value="<?php echo $login; ?>" placeholder="Nome de usuário (login)" />
                  </div>
                  <div class="6u$ 12u$(xsmall)">
                    Nome do usuário: <input type="text" name="nome" id="nome" value="<?php echo $nome; ?>" placeholder="Nome completo" />
                  </div>
                  <?php
                  //testa se é um cadastro de novo usuário
                  // só deixa informar senha se for um novo cadastro
                  if ($login == "" || $_SERVER['REQUEST_METHOD'] == 'POST'){
                      echo("<div class=\"6u 12u$(xsmall)\">
                      Senha:  <input type=\"password\" name=\"senha\" id=\"senha\" value=\"\" placeholder=\"Senha\" />
                      </div>
                      <div class=\"6u$ 12u$(xsmall)\">
                       Repetir a senha:  <input type=\"password\" name=\"senha-r\" id=\"senha-r\" value=\"\" placeholder=\"Repita a senha\" />
                      </div>");
                  }
                  ?>
                  <div class="4u 12u$(xsmall)">
                    <input type="radio" id="ind_Secretaria" value="ind_Secretaria" name="acesso" onchange="esconde_ra(this)" <?php echo $ind_Secretaria == 'S' ? 'checked' : false; ?>>
                    <label for="ind_Secretaria">Secretaria</label>
                  </div>
                  <div class="4u 12u$(xsmall)">
                    <input type="radio" id="ind_Aluno" value="ind_Aluno" name="acesso" onchange="esconde_ra(this)" <?php echo ($ind_Aluno == 'S' || empty($_GET))  ? 'checked' : false; ?>>
                    <label for="ind_Aluno">Aluno</label>
                  </div>
                  <div class="4u$ 12u$(xsmall)">
                    <input type="radio" id="ind_Professor" value="ind_Professor" name="acesso" onchange="esconde_ra(this)" <?php echo $ind_Professor == 'S' ? 'checked' : false; ?>>
                    <label for="ind_Professor">Professor</label>
                  </div>
                  <div class="6u$ 12u$(xsmall)" id="div_ra" <?php if($ind_Aluno == "N") echo " hidden=true "; ?> >
                    RA: <input type="text" name="ra" id="ra" value="<?php echo $RA; ?>" placeholder="RA" />
                  </div>
                  <div class="12u$">
                    <ul class="actions">
                      <?php
                      if (!empty($_GET)) {
                        if ($total) {
                          echo "<li><input type=\"submit\" value=\"Alterar\" name=\"Alterar\" class=\"special\" /></li>";
                          echo "<li><input type=\"submit\" value=\"Excluir\" name=\"Excluir\" class=\"special\" /></li>";
                          echo "<li><input type=\"submit\" value=\"Senha\" name=\"Senha\" class=\"special\" /></li>";
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
                <input type="hidden" name="id_usuarios" id="id_usuarios" value="<?php echo $id_usuarios; ?>" />
              </form>
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
            <script>
            function esconde_ra(checkboxElem) {
              var ind_Aluno = document.getElementById ( "ind_Aluno" ) ;
              var ra = document.getElementById ( "div_ra" ) ;

              if (ind_Aluno.checked) {
                ra.hidden = false ;
              } else {
                ra.hidden = true ;
              }
            }
            </script>
</body>
</html>
