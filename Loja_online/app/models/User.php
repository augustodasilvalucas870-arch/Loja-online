<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($nome, $email, $senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (nome,email,senha) VALUES (?,?,?)"
        );
        return $stmt->execute([$nome,$email,$hash]);
    }

    public function login($email, $senha) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($senha,$user['senha'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
