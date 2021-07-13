<?php
function connection(){
    $server="localhost";
    $user="root";
    $password="Casillas123";
    $dbName="MyPage";
    $conn = mysqli_connect($server, $user, $password, $dbName) or die("Cannot connect to database");
    return $conn;
}
