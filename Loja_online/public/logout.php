<?php
session_start();

/* Limpa todos os dados da sessão */
session_unset();

/* Destroi a sessão */
session_destroy();

/* Redireciona para a página inicial */
header("Location: index.php");
exit;
