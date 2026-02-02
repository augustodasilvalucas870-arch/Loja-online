<?php
session_start();
require "../config/database.php";
require "../models/User.php";

$user = new User($pdo);

if($_POST) {
    if($user->login($_POST['email'], $_POST['senha'])) {
        header("Location: ../../public/index.php");
    } else {
        echo "Login inválido";
    }
}
