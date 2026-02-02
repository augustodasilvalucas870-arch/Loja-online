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

// API Multicaixa Express (exemplo genérico)
$apiUrl = "https://sandbox.multicaixa.co.mz/payment";
$token = "SEU_TOKEN_MULTICAIXA";

$data = [
    "pedido_id" => $pedidoId,
    "valor" => $total,
    "moeda" => "MZN",
    "descricao" => "Pagamento pedido #".$pedidoId,
    "callback" => "http://localhost/loja-online/public/retorno_multicaixa.php"
];

// Requisição POST
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
$response = curl_exec($ch);
curl_close($ch);

$resposta = json_decode($response, true);
if(isset($resposta['payment_url'])){
    header("Location: ".$resposta['payment_url']);
    exit;
}else{
    echo "Erro no pagamento Multicaixa";
}
