<?php

Class Router{

    public static function run(string $uri, string $method )
    {
        
        switch ($uri) {
            case '/':
                echo "<h1>Bem-vindo ao Sistema Imobiliario</h1>";
                break;
            case '/imoveis':
                echo "<h1>Lista de Imóvies</h1>";
                break;
            case '/Corretores':
                echo "<h1>Lista de Corretores</h1>";
                break;
            case '/api/users':
                require_once __DIR__ . '/../Controller/AuthController.php';
                $authController = new AuthController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $authController->store();
                } else {
                    header('Content-Type: application/json');
                    http_response_code(405); // Method Not Allowed
                    echo json_encode(["erro" => "Apenas requisições POST são permitidas nesta rota."]);
                }
                break;
            default:
                http_response_code(404);
                echo "<h1>Erro 404</h1>";
                break;
        }
    }
}

?>