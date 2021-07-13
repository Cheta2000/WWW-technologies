<?php

require_once "dbConnection.php";
require_once "testing.php";

session_name("mySession");
session_start();

$conn = connection();

$project = $opinion = $opinionErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project = test_input($_POST["projects"]);
    if (empty($_POST["opinion"])) {
        $opinionErr = "Opinia nie może być pusta";
    } else {
        $nick = $_SESSION["userName"];
        $gender = $_SESSION["userGender"];
        $opinion = test_input($_POST["opinion"]);
        $stmt = $conn->prepare("INSERT INTO Comments(`Nick`,`Gender`,`Project`,`Opinion`) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $nick, $gender, $project, $opinion);
        $stmt->execute();
    }
}
setcookie("page", "projects.php");
?>


<!DOCTYPE html>

<html lang="pl">

<head>
    <title>Moje projekty</title>
    <?php include "head.php"; ?>
</head>

<body>
    <header>
        <h1>Moje projekty</h1>
        <?php include "loginSection.php"; ?>
    </header>
    <nav class="col-11s col-12">
        <a href="index.php">O mnie</a>
        <div id="hidden">
            <a href="interests.php">Zainteresowania</a>
            <a class="active" href="projects.php">Projekty</a>
        </div>
        <?php include "hamburger.php"; ?>
    </nav>
    <section class="row">
        <article class="col-11s col-11">
            <h2>Chińskie warcaby</h2>
            <p>Aplikacja umożliwia granie w 2,3,4 lub 6 osób. Plansza jest w kształcie 6-ramiennej gwiazdy. Każdy gracz zaczyna z 10 pionkami konkretnego koloru, umieszczonymi w jednym z ramion. Celem gry jest przemieszczenie wszytskich pionków do ramienia
                znajdującego się na przeciwko. Można poruszać się, co jedno pole lub przeskakiwać inne pionki.<br> Aplikacja umożliwa także zapis gry do bazy danych oraz odtworzenie zakończonej gry.<br> Cała aplikacja bazuje na technologii klient-serwer.
                Serwer weryfikuje poprawność ruchów. Własnie ten element programu był najcięższy do stworzenia, gdyż dokładne zasady gry są dosyć skomplikowane
                <hr>
            <h2>Aplikacja do do obsługi sezonu w skokach narciarskich</h2>
            <p>Aplikacja jest graficznym interfejsem do obsługi bazy danych zawieracącej informacje o: skoczkach, trenerach, reprezentacjach, skoczniach i konkursach.<br> Daje nam dostęp do szerokiego zaplecza pomocnych funkcji, które szybko wyszukują
                często poszukiwane dane oraz zmieniają potrzebne informacje.<br> Ponadto w przyjazny sposób możemy stworzyć własne zapytanie do bazy danych. Ogranicza się to jedynie do wybrania i zaznaczenia odpowiednich poł.<br> Za pomocą aplikacja
                można także wykonać kopię zapasową całej bazy i ją wczytać.<br> Występują też oczywiście różne poziomy dostępu: admin, dyrektor, szef zawodów, trener, czy gość. Każda rola ma przydzielone konkretne uprawnienia.</p>
            <hr>
            <h2>Czat</h2>
            <p>Jest to prosty komunikator. Na początku następuje logowanie, poprzez podanie jedynie nazwy użytkownika. Za każdym razem, gdy ktoś zaloguje się lub opuści czat, użytkownik otrzymuje informacje o innych dostępnych użytkowniach, do których
                można wysłać wiadomość.<br> Mechanizm przesyłania nie jest skomplikowany, należy podać nazwę odbiorcy oraz treść wiadomości.</p>
            <hr>
            <h3>Aplikacja do rysowania</h3>
            <h3>Gra mastermind</h3>
        </article>
    </section>
    <?php
    if (isset($_SESSION["userId"])) {
        $addr = htmlspecialchars($_SERVER["PHP_SELF"]);
        echo '<form method="post" enctype="multipart/form-data" action=' . $addr . '>
                <table>
                    <tr>
                        <td>Projekt</td>
                        <td><select name="projects">
                        <option value="Warcaby">Warcaby</option>
                        <option value="Skoki">Skoki</option>
                        <option value="Czat">Czat</option>
                        <option value="Rysowanie">Rysowanie</option>
                        <option value="Mastermind">Mastermind</option>
                      </select></td>
                    </tr>
                    <tr>
                        <td>Opinia</td>
                        <td><textarea name="opinion" ></textarea></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="submit" value="Opublikuj" /></td>
                    </tr>
                </table>
            </form>';
    }
    ?>
    <section class="col-12s col-12">
        <h4>Komentarze</h4>
        <?php
        $query = "SELECT * FROM Comments";
        $result = mysqli_query($conn, $query);
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($counter > 12) {
                echo "<article id='$counter' style='display:none;' class='comment col-5s col-3'>";
            } else {
                echo "<article id='$counter' class='comment col-5s col-3'>";
            }
            echo "Nick: " . $row['Nick'];
            if ($row['Gender'] != "") {
                echo " (" . $row['Gender'] . ")";
            }
            echo "<br>" . "Projekt: " . $row['Project'];
            echo "<br>" . "Opinia: " . $row['Opinion'] . "<br>";
            echo "</article>";
            $counter++;
        }
        ?>
        <div class="buttons col-12s col-12">
            <button id="left">POPRZEDNIE</button>
            <button id="right">NASTĘPNE</button>
        </div>
    </section>
    <?php include "footer.php"; ?>
    <?php include "scriptInfo.php"; ?>
</body>

</html>