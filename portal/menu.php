<?php
// verifica se o usuário está corretamente logado
if((isset ($_SESSION['id_usuario']) == FALSE))
{
  unset($_SESSION['id_usuario']);
  unset($_SESSION['nome_usuario']);
  unset($_SESSION['ra']);
  unset($_SESSION['ind_aluno']);
  unset($_SESSION['ind_professor']);
  unset($_SESSION['ind_secretaria']);
  header('location:login.php');
  }

// a rotina abaixo verifica se o usuário tem permissão pra acessar a pagina atual
// se não tiver, joga ele pra pagina principal
if((isset ($_SESSION['acesso']) == TRUE)){
  $permite_acesso = FALSE;
  $acessos = $_SESSION['acesso'];

  foreach ($acessos as &$acesso) {
    if ($_SESSION[$acesso] === 'S') {
      $permite_acesso = true;
    }
  }
  unset($acesso);
  if ($permite_acesso == FALSE) {
    if (basename($_SERVER['PHP_SELF']) != "principal.php"){
      header('location:principal.php');
    }
  }
}
?>
<!-- Header -->
<header id="header">
    <h1>Bem vindo(a), <strong><?php echo utf8_encode($_SESSION["nome_usuario"]); ?> </strong></h1>
    <nav id="nav">
        <ul>
                <?php
                echo "<li><a href=\"principal.php\">Início </a></li>";
                echo ($_SESSION["ind_secretaria"] === 'S' ? "<li><a href=\"usuarios.php\">Usuários</a></li>" : "");
                echo ($_SESSION["ind_secretaria"] === 'S' ? "<li><a href=\"materias.php\">Disciplinas</a></li>" : "");
                echo ($_SESSION["ind_secretaria"] === 'S' ? "<li><a href=\"matricula.php\">Matrícula</a></li>" : "");
                echo (in_array("S", [$_SESSION["ind_aluno"], $_SESSION["ind_professor"]]) ? "<li><a href=\"notas.php\">Notas e Faltas</a></li>" : "");
                //echo ($_SESSION["ind_professor"] === 'S' ? "<li><a href=\"lancamentos.php\">Lançamentos</a></li>" : "");
                ?>
              <!-- <li><a href="generic.html">Generic</a></li>
              <li><a href="elements.html">Elements</a></li> -->
              <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
</header>
<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
