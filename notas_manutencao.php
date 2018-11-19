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
  $_SESSION["acesso"] = ["ind_professor"];
  // Carrega o Menu de navegação
  require "portal/menu.php";
    ?>

    <!-- Main -->
      <section id="main" class="wrapper">
        <div class="container">
          <header class="major special">
            <h2>Lançamentos de Notas e Faltas</h2>
            <p>Informe os dados de notas e faltas.</p>
          </header>

    <?php
    if (!empty($_GET)) {
        $SQL = "SELECT a.materia , (select max(nome) from usuarios where id_usuarios = a.usuarios_id_usuarios) as professor ,
            u.nome as aluno, m.nota, m.presencas, m.faltas, m.ind_ativo, m.ind_revisao, m.ind_revisado,
            m.ind_aprovacao, m.ind_reprovacao, m.id_matriculas  FROM matriculas m
            inner join usuarios u on m.usuarios_id_usuarios = u.id_usuarios
            inner join materias a on m.materias_id_materias = a.id_materias
            where m.id_matriculas ='" . $_GET['m'] . "'";
            " order by materia ";
        $result_id = @mysqli_query($conn, $SQL) or die("Erro no banco de dados!");
        $total = @mysqli_num_rows($result_id);
        // Caso o usuário tenha digitado um login válido o número de linhas será 1..
        if ($total) {
            $dados = @mysqli_fetch_array($result_id);

            $materia = $dados["materia"];
            $aluno = $dados["aluno"];
            $nota = $dados["nota"];
            $presencas = $dados["presencas"];
            $faltas = $dados["faltas"];
            $id_matriculas = $dados["id_matriculas"];
        } else {
            $materia = "";
            $aluno = "";
            $nota = "";
            $presencas = "";
            $faltas = "";
            $id_matriculas = "";
            header('location:notas.php');
        }
    } else {
        $materia = "";
        $aluno = "";
        $nota = "";
        $presencas = "";
        $faltas = "";
        $id_matriculas = "";
        header('location:notas.php');
    }
    ?>
          <!-- Form -->
            <section>
              <h3>Cadastrar nova matrícula</h3>
              <form method="post" accept-charset="utf-8">
                <div class="row uniform 50%">

                  <div class="6u 12u$(xsmall)">
                    <input type="text" disabled name="materia" id="materia" value="<?php echo $materia; ?>" placeholder="Matéria" />
                  </div>
                  <div class="6u$ 12u$(xsmall)">
                    <input type="text" disabled name="aluno" id="aluno" value="<?php echo $aluno; ?>" placeholder="Aluno" />
                  </div>
                  <div class="4u 12u$(xsmall)">
                  Nota:  <input type="text" name="nota" id="nota" value="<?php echo $nota; ?>" placeholder="Nota" />
                  </div>
                  <div class="4u 12u$(xsmall)">
                  Presenças:  <input type="text" name="presencas" id="presencas" value="<?php echo $presencas; ?>" placeholder="Presencas" />
                  </div>
                  <div class="4u$ 12u$(xsmall)">
                  Faltas:  <input type="text" name="faltas" id="faltas" value="<?php echo $faltas; ?>" placeholder="Faltas" />
                  </div>
                  <input type="hidden" name="id_matriculas" id="id_matriculas" value="<?php echo $id_matriculas; ?>" />
                  <div class="12u$">
                    <ul class="actions">
                        <?php
                        echo "<li><input type=\"submit\" value=\"Alterar\" name=\"Alterar\" class=\"special\" /></li>";
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
        header('location:notas.php');
    }

    $nota = isset($_POST["nota"]) ? trim($_POST["nota"]) : false;
    $presencas = isset($_POST["presencas"]) ? trim($_POST["presencas"]) : false;
    $faltas = isset($_POST["faltas"]) ? trim($_POST["faltas"]) : false;
    $id_matriculas = isset($_POST["id_matriculas"]) ? trim($_POST["id_matriculas"]) : false;


    if (isset($_POST['Incluir'])) {

    } elseif (isset($_POST['Alterar'])) {
        $SQL = "update matriculas set nota  = '" .  $nota . "'," .
                "               presencas  = '" .  $presencas . "'," .
                "               faltas  = '" .  $faltas . "' " .
                " where id_matriculas = '". $id_matriculas . "'";
        mysqli_query($conn, $SQL);
    } elseif (isset($_POST['Excluir'])) {

    }

    header('location:notas.php');
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
