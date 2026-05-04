<?php
$host = "car_db";
$user = "caruser";
$password = "carpass";
$database = "car_rent";

$yhendus = mysqli_connect($host, $user, $password, $database);

if (!$yhendus) {
    die("Andmebaasi ühendus ebaõnnestus: " . mysqli_connect_error());
}

mysqli_set_charset($yhendus, "utf8mb4");
?>