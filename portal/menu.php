<!-- Header -->
<header id="header">
    <h1>Bem vindo(a), <strong><?php echo utf8_decode($_SESSION["nome_usuario"]); ?> </strong></h1>
    <nav id="nav">
        <ul>
              <li><a href="index.html">Início </a></li>
                <?php
                echo ($_SESSION["ind_secretaria"] === 'S' ? "<li><a href=\"usuarios.html\">Usuários</a></li>" : "");
                echo (in_array("S", [$_SESSION["ind_aluno"], $_SESSION["ind_professor"]]) ? "<li><a href=\"materias.html\">Materias</a></li>" : "");
                echo (in_array("S", [$_SESSION["ind_aluno"], $_SESSION["ind_professor"]]) ? "<li><a href=\"notas.html\">Notas</a></li>" : "");
                ?>
              <li><a href="ajuda.html">Ajuda</a></li>
              <li><a href="generic.html">Generic</a></li>
              <li><a href="elements.html">Elements</a></li>
              <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
</header>
<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
