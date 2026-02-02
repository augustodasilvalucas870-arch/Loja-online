<?php
session_start();
require "../config/database.php";

if ($_POST) {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=?");
    $stmt->execute([$email, $senha]);

    if ($stmt->rowCount()) {
        $_SESSION['user'] = $stmt->fetch();
        header("Location: dashboard.php");
    } else {
        $erro = "Credenciais inválidas";
    }
}
?>