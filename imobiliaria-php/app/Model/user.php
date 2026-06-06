<?php

require_once __DIR__ . '/../core/Database.php';

class User{

    public function create(string $nome, string $email, string $senha, string $role ): bool{

    $banco = Database::connect();
    //:var ou ? = placeholder no lugar de variaveis
    $sql = "INSERT INTO users (nome, email, senha, role) 
        VALUES (:nome, :email, :senha, :role)";
    
    //prepare = segurança
    $stmt = $banco->prepare($sql);

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    return $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email,
            ':senha' => $senhaCriptografada,
            ':role'  => $role
        ]);

    }
    
    /*
    public function getAllUsers(){

        $banco = Database::connect();

        $sql = "SELECT id, nome, email, role * FROM users"


    }*/
}


?>