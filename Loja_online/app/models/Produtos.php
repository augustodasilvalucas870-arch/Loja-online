<?php
class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listar() {
        return $this->pdo->query("SELECT * FROM produtos")->fetchAll();
    }

    public function buscar($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
