<?php

require_once "testing.php";
require_once "dbConnection.php";


$conn = connection();

$error = $nick = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = test_input($_POST["nick"]);
    $pass = test_input($_POST["password"]);
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Nick=? OR `E-mail`=?;");
    $stmt->bind_param("ss", $nick, $nick);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $hashPass = $row["Password"];
        $logged = password_verify($pass, $hashPass);
        if ($logged) {
            session_name("mySession");
            session_start();
            $_SESSION["userId"] = $row["Id"];
            $_SESSION["userName"] = $row["Nick"];
            $_SESSION["userGender"] = $row["Gender"];
            $location = $_COOKIE["page"];
            header("Location:$location");
            exit();
        } else {
            $error = "Nieprawidłowe dane logowania";
        }
    } else {
        $error = "Nieprawidłowe dane logowania";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Login</title>
    <?php include "head.php"; ?>
</head>
<header>
    <h1>LOGIN</h1>
    <?php include "loginSection.php"; ?>
</header>

<body>
    <nav class="col-7s col-12">
        </button>
        <a href="index.php">O mnie</a>
        <div id="hidden">
            <a href="interests.php">Zainteresowania</a>
            <a href="projects.php">Projekty</a>
        </div>
        <?php include "hamburger.php"; ?>
    </nav>
    <section class="col-4s col-12">
        <article class="register">
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table>
                    <tr>
                        <td>Nick/E-mail</td>
                        <td><input type="text" name="nick" maxlength="40" size="10"></td>
                    </tr>
                    <tr>
                        <td>Hasło</td>
                        <td><input type="password" name="password" maxlength="30" size="10"></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="submit" value="ZALOGUJ" /></td>
                    </tr>
                    <tr>
                        <span class="error"><?php echo $error; ?></span>
                    </tr>
                </table>
            </form>
        </article>
    </section>
    <?php include "footer.php"; ?>
    <?php include "scriptInfo.php"; ?>
</body>

</html>