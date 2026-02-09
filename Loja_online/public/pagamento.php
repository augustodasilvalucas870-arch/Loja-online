<?php
session_start();

if (!isset($_SESSION['user'])) {
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
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Escolher método de pagamento</h2>

<form method="POST" action="finalizar_compra.php">

    <label>
        <input type="radio" name="pagamento" value="multicaixa" required>
        Multicaixa Express
    </label><br><br>

    <label>
        <input type="radio" name="pagamento" value="paypal">
        PayPal
    </label><br><br>

    <label>
        <input type="radio" name="pagamento" value="dinheiro">
        Pagamento na entrega
    </label><br><br>

    <button type="submit">Confirmar pagamento</button>
</form>

</body>
</html>
