<?php

require_once __DIR__ .'/../Model/user.php';

class AuthController{

    public function store()
    {
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');

        $dados = json_decode($json, true);


        $nome = $dados['nome'] ?? '';
        $email = $dados['email'] ?? '';
        $senha = $dados['senha'] ?? '';
        $role = $dados['role'] ?? 'cliente';


        if (empty($nome) || empty($email) || empty($senha)) {
            http_response_code(400);
            echo json_encode(["erro" => "Todos os campos (nome, email, senha) são obrigatórios!"]);
            return;
        }

        // 3. Chama o Model que você criou
        $userModel = new User();
        
        // 4. Executa o cadastro e verifica o retorno booleano
        try {
            // Tenta criar o usuário
            $userModel->create($nome, $email, $senha, $role);
            
            http_response_code(201); // Created
            echo json_encode([
                "mensagem" => "Usuário criado com sucesso!",
                "usuario" => ["nome" => $nome, "email" => $email, "role" => $role]
            ]);

        } catch (PDOException $e) {
            // O código 23000 no SQL significa "Violação de Integridade" (ex: e-mail duplicado)
            if ($e->getCode() == 23000) {
                http_response_code(409); // Conflict
                echo json_encode(["erro" => "Este e-mail já está em uso no sistema."]);
            } else {
                // Para outros erros de banco, devolvemos um erro 500 genérico 
                // e não mostramos a mensagem real do banco pro usuário por segurança.
                http_response_code(500); // Internal Server Error
                echo json_encode(["erro" => "Erro interno ao processar o cadastro.", "Erro2" => $e]);
                
                // Em um sistema real, aqui você usaria um error_log($e->getMessage()) para salvar num TXT
            }
        }


    }
}

?>