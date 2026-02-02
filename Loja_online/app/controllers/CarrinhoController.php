<?php
session_start();

class CarrinhoController {
    public static function adicionar($id) {
        $_SESSION['carrinho'][$id] =
            ($_SESSION['carrinho'][$id] ?? 0) + 1;
    }

    public static function listar() {
        return $_SESSION['carrinho'] ?? [];
    }
}
