<?php
include "../config/database.php";
$id = $_GET['id'];
$con->query("DELETE FROM funcionarios WHERE id=$id");
header("Location: listar.php");