<!-- Footer -->
<footer id="footer">
    <div class="container">
        <!-- <ul class="icons">
            <li><a href="#" class="icon fa-facebook"></a></li>
            <li><a href="#" class="icon fa-twitter"></a></li>
            <li><a href="#" class="icon fa-instagram"></a></li>
        </ul> -->
        <?php
echo "<small>";
//  echo "ID do usuário: "   . $_SESSION["id_usuario"]   . "";
echo " Usuário: " . $_SESSION["nome_usuario"] . " - ";
echo " Acesso: " . ($_SESSION["ind_aluno"] === 'S' ? "Aluno" : ($_SESSION["ind_professor"] === 'S' ? "Professor" : "Secretaria")) . "";
echo "</small>";
?>
        <ul class="copyright">
            <li>&copy; Untitled</li>
            <li>Design: <a href="http://templated.co">TEMPLATED</a></li>
            <li>Images: <a href="http://unsplash.com">Unsplash</a></li>
        </ul>
        </div>
</footer>
