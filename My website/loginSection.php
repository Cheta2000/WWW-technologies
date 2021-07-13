<section class="login">
    <?php
    session_name("mySession");
    session_start();
    if (isset($_SESSION["userId"])) {
        echo "Użytkownik: " . $_SESSION["userName"];
        echo "<br><a href='logout.php'>Wyloguj</a>";
        echo "<br><a href='delete.php'>Usuń konto</a>";
    } else {
        echo "<a href='signup.php'>Rejestracja</a>
        <br>
        <a href='login.php'>Logowanie</a>";
    }; ?>
</section>