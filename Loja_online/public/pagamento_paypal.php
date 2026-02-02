<?php
session_start();
require "../app/config/database.php";
require "../app/models/Pedido.php";

$total = $_POST['total'];
$userId = $_SESSION['user']['id'] ?? null;

if(!$userId){
    header("Location: login.php");
    exit;
}

// Cria pedido antes do pagamento
$pedidoModel = new Pedido($pdo);
$pedidoId = $pedidoModel->criar($userId, $total);

// PayPal API sandbox
$clientId = "SEU_CLIENT_ID_PAYPAL";
$secret = "SEU_SECRET_PAYPAL";

// Gerar token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json","Accept-Language: en_US"]);
curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$tokenData = json_decode($response, true);
$accessToken = $tokenData['access_token'] ?? '';

// Criar pagamento (exemplo simples)
header("Location: https://www.sandbox.paypal.com/checkoutnow?token=".$pedidoId);
exit;
