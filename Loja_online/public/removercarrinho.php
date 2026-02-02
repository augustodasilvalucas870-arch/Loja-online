<?php
session_start();

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    if(isset($_SESSION['carrinho'][$id])){
        unset($_SESSION['carrinho'][$id]);
    }
}

header("Location: carrinho.php");
exit;
