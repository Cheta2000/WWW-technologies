<?php
require_once "dbConnection.php";
$conn = connection();
$stmt = $conn->prepare("INSERT INTO Visitors
(`Ip`, `Date`) VALUES (?, ?)");
$ip = $_SERVER["REMOTE_ADDR"];
$date = date("Y-m-d H:i:s");
$stmt->bind_param("ss", $ip, $date);
$stmt->execute();
setcookie("page", "index.php");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>O mnie</title>
    <?php include "head.php"; ?>
</head>

<body>
    <header>
        <h1>Witaj na mojej stronie</h1>
        <?php include "loginSection.php"; ?>
    </header>
    <nav class="col-7s col-12">
        </button>
        <a class="active" href="index.php">O mnie</a>
        <div id="hidden">
            <a href="interests.php">Zainteresowania</a>
            <a href="projects.php">Projekty</a>
        </div>
        <?php include "hamburger.php"; ?>
    </nav>
    <section class="row">
        <article class="col-7s col-5">
            <h2>O mnie</h2>
            <p>Nazywam się Mateusz Chęciński. Mam 20 lat. Pochodzę z Wrocławia.<br> Uczyłem sie w Gimnazjum nr 14 oraz w Liceum Ogołnokszałcącym nr 3. Aktualnie studiuję na Politechnice Wrocławskiej na wydziale Podstawowych Problemów Techniki. Jestem na
                2. roku Informatyki Algorytmicznej.<br> Interesuje się wieloma dziedzinami informatycznymi, łamigłówkami i sportem. Czynnie go uprawiam. Swoją przyszłość wiążę z informatyką, jeszcze nie wiem w jakiej konkretnej dziedzienie. Chciałbym
                choć odrobinę to połączyć z aktywnościa fizyczną.<br> Na stronie znajdziesz bardziej szczegółowe informacje o moich zainteresowaniach oraz projektach, a także moje dane kontakowe.<br> Miłej lektury!</p>
        </article>
        <img id="me" src="img/my-photo.jpg" alt="Ja" />
        <aside class="col-4s col-3">
            <h3>Kontakt: </h3>
            <p>Email: <a href="mailto:mati28500@gmail.com" target="_blank">mati28500@gmail.com</a></p>
            <p>Telefon: 530713733 </p>
            <p>Facebook: <a href="https://www.facebook.com/mateusz.checinski.16/" target="_blank">Mateusz Chęciński</a></p>
            <img id="phone" src="img/phone.jpg" alt="Telefon" />
        </aside>
    </section>
    <div class="visitors col-4s col-3">
        <?php $query = "SELECT * FROM Visitors GROUP BY DAY(`Date`),`Ip`";
        $visitors = mysqli_query($conn, $query);
        $counter = mysqli_num_rows($visitors);
        echo "Odwiedziny: " . $counter; ?>
    </div>
    <?php include "footer.php"; ?>
    <?php include "scriptInfo.php"; ?>
</body>

</html>