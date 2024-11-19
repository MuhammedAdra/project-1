<?php
$database_info = include __DIR__ . "/config/database.php";
$connect=mysqli_connect(
    $database_info['servername'],
    $database_info['usermame'],
    $database_info['password'],
    $database_info['database'],
    $database_info['port']
);

if(!$connect){
    die("connection faild ".mysqli_connect_error());
}

mysqli_close($connect);