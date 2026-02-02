<?php
include "../config/conexao.php";
$result = $con->query("SELECT * FROM funcionarios");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Funcionários</title>
</head>
<body>

<h2>Lista de Funcionários</h2>
<a href="cadastrar.php">+ Novo Funcionário</a>

<table>
<tr>
    <th>Nome</th>
    <th>Cargo</th>
    <th>Salário</th>
    <th>Ações</th>
</tr>

<?php while($f = $result->fetch_assoc()): ?>
<tr>
    <td><?= $f['nome'] ?></td>
    <td><?= $f['cargo'] ?></td>
    <td><?= number_format($f['salario'], 2, ',', '.') ?> Kz</td>
    <td>
        <a href="editar.php?id=<?= $f['id'] ?>">Editar</a> |
        <a href="excluir.php?id=<?= $f['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</body>
</html>