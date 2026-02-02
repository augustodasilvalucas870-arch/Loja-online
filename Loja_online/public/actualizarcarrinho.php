<?php
session_start();

if(isset($_GET['id']) && isset($_GET['qtd'])){
    $id = (int)$_GET['id'];
    $qtd = (int)$_GET['qtd'];

    if($qtd > 0){
        $_SESSION['carrinho'][$id] = $qtd;
    } else {
        unset($_SESSION['carrinho'][$id]);
    }
}

header("Location: carrinho.php");
exit;
