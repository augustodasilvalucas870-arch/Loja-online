<?php
require "../config/database.php";
require "../models/Pedido.php";

$pedido = new Pedido($pdo);
$pedido->criar($_SESSION['user']['id'], $_POST['total']);
