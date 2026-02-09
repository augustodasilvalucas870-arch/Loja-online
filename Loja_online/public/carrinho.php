<?php

require "../app/config/database.php";
require_once "../app/helpers/auth.php";

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>O meu carrinho</title>
    <link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>

<body class="cart-body">

<div class="cart-overlay">
    <div class="cart-container">

        <div class="cart-header">
            <h2>🛒 O teu carrinho</h2>
            <a href="index.php" class="cart-close">✕</a>
        </div>

        <div id="cart-content"></div>

        <div class="cart-footer">
            <span>Total:</span>
            <strong id="cart-total">0 Kz</strong>
        </div>

       
<form action="finalizar_compra.php" method="POST">
    <button type="submit" class="btn-primary full">
        Finalizar compra
    </button>
</form>




       
    </div>
</div>

              
<script src="assets/js/carrinho.js"></script>

</body>
</html>