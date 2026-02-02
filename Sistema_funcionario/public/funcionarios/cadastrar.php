<?php
include "../config/database.php";

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];

    $con->query("INSERT INTO funcionarios (nome, cargo, salario)
                 VALUES ('$nome', '$cargo', '$salario')");
    header("Location: listar.php");
}
?>

<form method="post">
    <input name="nome" placeholder="Nome" required>
    <input name="cargo" placeholder="Cargo" required>
    <input name="salario" type="number" step="0.01" placeholder="Salário" required>
    <button name="salvar">Salvar</button>
</form>