<?php
include "../config/database.php";
$id = $_GET['id'];

$f = $con->query("SELECT * FROM funcionarios WHERE id=$id")->fetch_assoc();

if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];

    $con->query("UPDATE funcionarios SET 
        nome='$nome', cargo='$cargo', salario='$salario'
        WHERE id=$id");

    header("Location: listar.php");
}
?>

<form method="post">
    <input name="nome" value="<?= $f['nome'] ?>">
    <input name="cargo" value="<?= $f['cargo'] ?>">
    <input name="salario" value="<?= $f['salario'] ?>">
    <button name="atualizar">Atualizar</button>
</form>