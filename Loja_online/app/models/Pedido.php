<?php
class Pedido {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($userId, $total) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO pedidos (user_id,total,status) VALUES (?,?,?)"
        );
        $stmt->execute([$userId,$total,"Pago"]);
        return $this->pdo->lastInsertId();
    }
}
