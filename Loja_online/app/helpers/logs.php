<?php
function logAdmin($pdo, $acao, $descricao = null) {
    $stmt = $pdo->prepare(
        "INSERT INTO adm_logs (admin_id, acao, descricao, ip_address, user_agent)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->execute([
        $_SESSION['user']['id'],
        $acao,
        $descricao,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    ]);
}
