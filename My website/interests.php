<?php
setcookie("page", "interests.php"); ?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Moje zainteresowania</title>
    <?php include "head.php"; ?>
</head>

<body>
    <header>
        <h1>Moje zainteresowania</h1>
        <?php include "loginSection.php"; ?>
    </header>
    <nav class="col-6s col-12">
        <a href="index.php">O mnie</a>
        <div id="hidden">
            <a class="active" href="interests.php">Zainteresowania</a>
            <a href="projects.php">Projekty</a>
        </div>
        <?php include "hamburger.php"; ?>
    </nav>
    <div class="row">
        <section class="col-12s col-8">
            <article class="col-6s col-12">
                <h2>INFORMATYKA</h2>
                <h3><i>Cyberbezpieczeństwo i kryptologia</i></h3>
                <p>Interesuję się wszelkimi rodzaju szyframi i kodami. Staram się być na bieżąco z najnowszymi technologiami. Z tego też powodu planuję zapisać się na drugi kierunek studiów: cyberbezpieczeństwo.<br> Chciałbym rozwinąć się w tej dziedzinie,
                    aby w przyszłości mieć dużą możliwość wyboru, a także, aby systemy przeze mnie projetkowane były bezpieczne.</p>
                <hr>
                <h3><i>Sztuczna inteligencja</i></h3>
                <p>W tej dziedzienie jeszcze nie wiem zbyt wiele. Jest to wciąż rozwijająca się gałąź informatyki, która zyskuje na popularności. Pojawia się już prawie wszędzie: w grach, medycynie, czy roźnego rodzaju urządzeniach.<br> Fascynuje mnie fakt,
                    że komputer jest w stanie się uczyć, a także rozpoznawać obrazy, mowę i inne wzorce. Niedługo komputer całkowicie będzie mógł zastąpić człowieka!</p>
                <img class="small" src="img/ai.jpg" alt="Sztuczna inteligencja" />
                <hr>
                <h3><i>Arduino</i></h3>
                <p>Ostatnio zainteresowałem się technologią Arduino. Chcę zbudować własny escape room i jest to jedna z niezbędnych rzeczy. Odpowiada ona za mechanizmy elektroniczne. Jest to mini komputer, którą można odpowiednio zaprogramować.<br> Wygląda
                    on jak mała płytka, które przede wszytskim posiada wejścia, m.in. do podłączania róźnych czujników oraz wyjścia są podłączamy do urządzeń, którymi chcemy sterować.<br> Programowanie odbywa się w języku C. Za jego pomocą można stworzyć
                    np. sterownik rolet, oświetlenia, ogrzewania itd.
                </p>
                <img class="small" src="img/arduino.jpg" alt="arduino" />
            </article>
            <article class="up col-5s col-12">
                <h2>ZAINTERESOWANIA POZAINFORMATYCZNE</h2>
                <h3><i>Siatkówka</i></h3>
                <p>Trenuję siatkówkę odkąd Polska wygrała Mistrzostwa Świata w 2014. Zaczynałem swoją przygodę na AWF. Aktualnie gram w klubie WKS Volley Wilczyce na pozycji przyjmującego, choć w trakcie kariery byłem także rozgrywającym.<br> Staram się
                    mieć kontakt z siatkówką bez przerwy. Często oglądam mecze w telewizji oraz chodzę na siatkówkę plażową niezależnie od pogody. Od czasu do czasu, uda mi się pojechać na mecz na żywo.</p>
                <img class="small" src="img/volleyball.jpg" alt="Siatkówka" />
                <hr>
                <h3><i>Escape roomy</i></h3>
                <p>Wkręciłem się w escape roomy całkiem niedawno. Jest to też całkiem nowy rodzaj rozrywki. Zostajesz zamknięty ze swoją drużyną w pokoju na godzinę i twoim zadaniem jest się z niego wydostać. W tym celu należy rozwiązywać liczne zagadki,
                    wykazać się sprytem, współpracą oraz spostrzegawczością Jest to zabawa dla osób w każdym wieku, na pewno nikt nie będzie się nudził.<br> Odwiedziłem już ponad 50 pokoi, także poza Wrocławiem. Trzykrotnie brałem udział w Mistrzostwach
                    Polski. Ostatnim razem, mojemu zespołowi niewiele zabrakło do finału.</p>
                <img class="small" src="img/escape.jpg" alt="Escape room" />
                <hr>
                <h3><i>Skoki narciarskie</i></h3>
                <p>Jestem zagorzałym fanem skoków i od lat oglądam tę dyscyplinę w telewizji. Przede wszytskim kibicuję naszym skoczkom, choć mam też swoich ulubieńcow z innych reprezetacji. Przy każdym konkursie, towarzyszą mi niesamowite emocje. Nie omijam
                    żadnego. Widziałem wiele skoczni, lecz niestety, jeszcze nie udało mi się pojawić od skocznią w trakcie zawodów.<br> Sam skaczę na nartach jedynie w grach.Na komórce mam ich mnóstwo, a na komputerze często gram w popularną grę DSJ4.</p>
                <img class="small" src="img/jumping.jpg" alt="Skoki narciarskie" />
            </article>
        </section>
        <section class="col-4">
            <img class="large" src="img/ai.jpg" alt="Sztuczna inteligencja" />
            <img class="large" src="img/arduino.jpg" alt="arduino" />
            <img class="large" src="img/volleyball.jpg" alt="Siatkówka" />
            <img class="large" src="img/escape.jpg" alt="Escape room" />
            <img class="large" src="img/jumping.jpg" alt="Skoki narciarskie" />
        </section>
    </div>
    <?php include "footer.php"; ?>
    <?php include "scriptInfo.php"; ?>
</body>

</html>