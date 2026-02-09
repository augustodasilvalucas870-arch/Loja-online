<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Pagamento</title>
<style>
body {
    font-family: Arial;
    background: #f4f6f8;
}
.box {
    width: 400px;
    margin: 100px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
}
button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
.mc { background: #ff9800; color: #fff; }
.pp { background: #0070ba; color: #fff; }
</style>
</head>
<body>

<div class="box">
    <h2>Escolher método de pagamento</h2>

    <form action="processar_pagamento.php" method="POST">
        <button class="mc" name="metodo" value="multicaixa">
            Multicaixa Express
        </button>

        <button class="pp" name="metodo" value="paypal">
            PayPal
        </button>
    </form>
</div>

</body>
</html>
