<?php
require_once "dbConnection.php";
session_name("mySession");
session_start();
$conn = connection();
$id = $_SESSION["userId"];
$stmt = $conn->prepare("DELETE FROM Users WHERE Id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
header("Location:logout.php");
exit();
