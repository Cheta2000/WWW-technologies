<?php

require_once "testing.php";
require_once "dbConnection.php";

$conn = connection();

$counter = 0;

$nickErr = $passErr = $passRepErr = $mailErr = $nick = $gender = $pass = $passHash = $passRep = $mail = "";
$passOK = false;


function validate_pass($password)
{
    $conditions = array(
        '/[a-z]+/',
        '/[A-Z]+/',
        '/[0-9]+/',
        '/\S/',
        '/.{4,20}/'
    );

    foreach ($conditions as $value) {
        if (!preg_match($value, $password)) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nick"])) {
        $nickErr = "Nick jest polem wymaganym";
    } else {
        $nick = test_input($_POST["nick"]);
        $stmt = $conn->prepare("SELECT * FROM Users Where Nick=?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $exist = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($exist) > 0) {
            $nickErr = "Nick jest już zajęty";
        } else {
            $counter++;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gender = test_input($_POST["gender"]);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["password"])) {
        $passErr = "Hasło jest polem wymaganym";
    } else {
        $pass = test_input($_POST["password"]);
        $passOK = validate_pass($pass);
        if (!$passOK) {
            $passErr = "Hasło musi zawierać 4-20 znaków, w tym przynajmniej jedną dużą, jedną małą literę oraz przynajmniej jedną cyfrę";
        } else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $counter++;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["passwordRep"])) {
        $passRepErr = "Powtórzenie hasła jest pole wymaganym";
    } else {
        $passRep = test_input($_POST["passwordRep"]);
        if (strcmp($passRep, $pass) != 0) {
            $passRepErr = "Podane hasła nie są takie same";
        } else {
            $counter++;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["mail"])) {
        $mailErr = "E-mail jest polem wymaganym";
    } else {
        $mail = test_input($_POST["mail"]);
        $stmt = $conn->prepare("SELECT * FROM Users Where `E-mail`=?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $exist = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($exist) > 0) {
            $mailErr = "E-mail jest już zajęty";
        } else {
            $counter++;
        }
    }
}

if ($counter == 4) {
    $stmt = $conn->prepare("INSERT INTO Users(`Nick`,`Gender`,`Password`,`E-mail`) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $nick, $gender, $passHash, $mail);
    $stmt->execute();
    header("Location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Rejestracja</title>
    <?php include "head.php"; ?>
</head>
<header>
    <h1>REJESTRACJA</h1>
    <?php include "loginSection.php"; ?>
</header>

<body>
    <nav class="col-6s col-12">
        </button>
        <a href="index.php">O mnie</a>
        <div id="hidden">
            <a href="interests.php">Zainteresowania</a>
            <a href="projects.php">Projekty</a>
        </div>
        <?php include "hamburger.php"; ?>
    </nav>
    <section class="col-5s col-12">
        <article class="register">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <p><span class="error">*</span> pola wymagane</p>
                <table>
                    <tr>
                        <td>Nick</td>
                        <td><input type="text" name="nick" maxlength="40" size="10" required /><span class="error"> * <?php echo $nickErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Płeć</td>
                        <td>Mężczyzna<input type="radio" name="gender" value="M" />/Kobieta<input type="radio" name="gender" value="K" /></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><input type="email" name="mail" size="10" required /><span class="error"> * <?php echo $mailErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Hasło</td>
                        <td><input type="password" name="password" maxlength="30" size="10" required><span class="error"> * <?php echo $passErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Powtórz hasło</td>
                        <td><input type="password" name="passwordRep" maxlength="30" size="10" required /><span class="error"> * <?php echo $passRepErr; ?></span></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="reset" value="WYCZYŚĆ" /></td>
                        <td><input class="button" type="submit" value="ZAREJESTRUJ" /></td>
                    </tr>
                </table>
            </form>
        </article>
    </section>
    <?php include "footer.php"; ?>
    <?php include "scriptInfo.php"; ?>
</body>

</html>