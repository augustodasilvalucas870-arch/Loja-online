<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=loja_online;charset=utf8",
    "root",
    ""
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



