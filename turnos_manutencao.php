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
            <h2>Cadastro de Turnos</h2>
            <p>Informe os dados do turno.</p>
          </header>

    <?php
    if (!empty($_GET)) {
        $SQL = "SELECT turno, descricao , id_turnos FROM turnos WHERE id_turnos = '" . $_GET['t'] . "'";
        $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
        $total = @mysqli_num_rows($result_id);
        if ($total) {
            $dados = @mysqli_fetch_array($result_id);

            $turno = $dados["turno"];
            $descricao = $dados["descricao"];
            $id_turnos = $dados["id_turnos"];
        } else {
            $turno = "";
            $descricao = "";
            $id_turnos = "";
            header('location:turnos_manutencao.php');
        }
    } else {
        $turno = "";
        $descricao = "";
        $id_turnos = "";
    }
    ?>
          <!-- Form -->
            <section>
                <?php
                if ($turno != "") {
                    echo("<h3>Alterar dados do turno</h3>");
                } else {
                    echo("<h3>Cadastrar novo turno</h3>");
                }
                ?>
              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)">
                  Nome do turno: <input type="text" name="turno" id="turno" value="<?php echo $turno; ?>" placeholder="Nome do turno" />
                  </div>
                  <div class="6u$ 12u$(xsmall)">
                  Descrição do turno: <input type="text" name="descricao" id="descricao" value="<?php echo $descricao; ?>" placeholder="Descrição do turno" />
                  </div>
                  <input type="hidden" name="id_turnos" id="id_turnos" value="<?php echo $id_turnos; ?>" />

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
        header('location:turnos.php');
    }

    $turno = isset($_POST["turno"]) ? addslashes(trim($_POST["turno"])) : false;
    $descricao = isset($_POST["descricao"]) ? addslashes(trim($_POST["descricao"])) : false;
    $id_turnos = isset($_POST["id_turnos"]) ? trim($_POST["id_turnos"]) : false;

    if ($turno == "" || $descricao == "") {
      echo "<div style=\"text-align:center;\">É necessário informar todos os dados para incluir/alterar o registro!</div>";
    } else {
        if (isset($_POST['Incluir'])) {
            $SQL = "INSERT INTO turnos (turno, descricao)" .
                " VALUES ('". $turno . "', '" . $descricao . "') ";
            mysqli_query($conn, $SQL);
        } elseif (isset($_POST['Alterar'])) {
            $SQL = "update turnos set turno  = '" .  $turno . "'," .
               "                    descricao  = '" .  $descricao . "' " .
               " where id_turnos = '". $id_turnos . "'";
            mysqli_query($conn, $SQL);
        } elseif (isset($_POST['Excluir'])) {
            $SQL = "delete from turnos where id_turnos = '". $id_turnos . "'";
            mysqli_query($conn, $SQL);
        }
        //echo $SQL;
        header('location:turnos.php');
    }
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
