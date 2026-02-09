<?php
// Conexão com a base de dados
require_once '../app/config/database.php';

// Verifica se o ID foi enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: produtos.php');
    exit;
}

$id = (int) $_GET['id'];

// (Opcional) buscar imagem para apagar do servidor
$sqlImg = $pdo->prepare("SELECT imagem FROM produtos WHERE id = ?");
$sqlImg->execute([$id]);
$produto = $sqlImg->fetch();

if ($produto && !empty($produto['imagem'])) {
    $caminho = '../uploads/' . $produto['imagem'];
    if (file_exists($caminho)) {
        unlink($caminho);
    }
}

// Apagar produto da base de dados
$sql = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$sql->execute([$id]);

// Redireciona de volta à lista
header('Location: produtos.php');
exit;
