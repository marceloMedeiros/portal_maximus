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
  $_SESSION["acesso"] = ["ind_aluno", "ind_professor", "ind_secretaria"];
  // Carrega o Menu de navegação
  require "portal/menu.php";
    ?>



    <!-- Main -->
      <section id="main" class="wrapper">
        <div class="container">
          <header class="major special">
            <h2>Alterar a senha de acesso</h2>
            <!-- <p>Informe os dados do usuário.</p> -->
          </header>

          <?php
          if (!empty($_GET)) {
              $SQL = "SELECT id_usuarios , login , senha , nome FROM usuarios WHERE id_usuarios = '" . $_GET['l'] . "'";
              $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
              $total = @mysqli_num_rows($result_id);
              // Caso o usuário tenha digitado um login válido o número de linhas será 1..
              if ($total) {
                  $dados = @mysqli_fetch_array($result_id);

                  $id_usuarios = $dados["id_usuarios"];
                  $login = $dados["login"];
                  $nome = $dados["nome"];
                  $senha = $dados["senha"];

                  $_SESSION['alt_senha'] = "?l=" . $_GET['l'];
              } else {
                  $id_usuarios = "";
                  $login = "";
                  $nome = "";
                  $senha = "";
                  $_SESSION['alt_senha'] ="";
                  header('location:principal.php');
                  exit();
              }
          } else {
              $_SESSION['alt_senha'] ="";
              $id_usuarios = $_SESSION["id_usuario"] ;

              $SQL = "SELECT id_usuarios , login , senha , nome FROM usuarios WHERE id_usuarios = '" . $id_usuarios . "'";
              $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
              $total = @mysqli_num_rows($result_id);
              // Caso o usuário tenha digitado um login válido o número de linhas será 1..
              if ($total) {
                  $dados = @mysqli_fetch_array($result_id);

                  $id_usuarios = $dados["id_usuarios"];
                  $login = $dados["login"];
                  $nome = $dados["nome"];
                  $senha = $dados["senha"];

              } else {
                  $id_usuarios = "";
                  $login = "";
                  $nome = "";
                  $senha = "";

                  header('location:principal.php');
                  exit();
              }
          }
          ?>

          <!-- Form -->
            <section>
                <!-- <h3>Alterar a senha de acesso</h3> -->

                <?php
                // Só entra aqui se for um postback
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  if (isset($_POST['Voltar'])) {
                    header('location:usuarios_manutencao.php?l=' . $id_usuarios);
                  }
                    $id_usuarios = isset($_POST["id_usuarios"]) ? addslashes(trim($_POST["id_usuarios"])) : false;
                    $login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : false;
                    $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
                    $senha_ori = isset($_POST["senha_ori"]) ? md5(trim($_POST["senha_ori"])) : false;
                    $senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : false;
                    $senha_decript = isset($_POST["senha"]) ? trim($_POST["senha"]) : false;
                    $senha_r = isset($_POST["senha_r"]) ? md5(trim($_POST["senha_r"])) : false;
                    $op = isset($_POST["op"]) ? trim($_POST["op"]) : false;

                    if (isset($_POST['Alterar'])) {
                        if ($senha != $senha_r) {
                          echo "<div style=\"text-align:center; color:red;\">As senhas informadas não coincidem!</div><br/>";
                        } elseif (strlen($senha_decript) < 5){
                          echo "<div style=\"text-align:center; color:red;\">Senha deve ter ao menos 5 caracteres!</div><br/>";
                        } else {

                            //testa se a senha atual foi informada corretamente
                            $SQL = "SELECT senha  FROM usuarios WHERE id_usuarios = '" . $id_usuarios . "'";
                            $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
                            $dados = @mysqli_fetch_array($result_id);
                            if ($op != "outros" && $senha_ori != $dados["senha"]) {
                                  echo "<div style=\"text-align:center; color:red;\">Senha atual incorreta!</div><br/>";
                                  //exit();
                            } else {
                                mysqli_query(
                                    $conn, "update usuarios set senha  = '" .  $senha . "' " .
                                    " where id_usuarios = '". $id_usuarios . "'"
                                );
                                if ($_SESSION['alt_senha'] != ""){
                                  header('location:usuarios_manutencao.php' . $_SESSION['alt_senha']);
                                } else {
                                  header('location:principal.php');
                                }
                                exit();
                            }
                        }
                    }
                }
                ?>
              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)" <?php  if (empty($_GET)) echo " hidden=\"true\""; ?>>
                    Login:  <input type="text" readonly name="login" id="login" value="<?php echo $login; ?>" placeholder="Nome de usuário (login)" />
                  </div>
                  <div class="6u$ 12u$(xsmall)" <?php  if (empty($_GET)) echo " hidden=\"true\""; ?>>
                    Nome do usuário: <input type="text" readonly name="nome" id="nome" value="<?php echo $nome; ?>" placeholder="Nome completo" />
                  </div>
                  <div <?php  if (!empty($_GET)) echo " hidden=\"true\""; ?> class="4u 12u$(xsmall)">
                      Senha atual:  <input type="password" tabindex="1" name="senha_ori" id="senha_ori" value="" placeholder="Senha atual" />
                  </div>
                  <div class="4u 12u$(xsmall)">
                      Nova senha:  <input type="password" tabindex="2" name="senha" id="senha" value="" placeholder="Nova senha" />
                  </div>
                  <div class="4u$ 12u$(xsmall)">
                      Repetir a nova senha:  <input type="password" tabindex="3" name="senha_r" id="senha_r" value="" placeholder="Repetir a nova senha" />
                  </div>
                  <div class="12u$">
                    <ul class="actions">
                      <li><input type="submit" tabindex="4" value="Alterar" name="Alterar" class="special" /></li>
                      <li><input type="submit" tabindex="5" value="Voltar" name="Voltar" class="special" <?php  if (empty($_GET)) echo " style=\"display:none;\""; ?>/></li>
                    </ul>
                  </div>
                </div>
                <input type="hidden" name="id_usuarios" id="id_usuarios" value="<?php echo $id_usuarios; ?>" />
                <input type="hidden" name="op" id="op" value="<?php  if (!empty($_GET)) echo "outros"; ?>" />
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
</body>
</html>
