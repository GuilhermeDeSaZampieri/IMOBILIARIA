<?php

Class Router{

    private array $routes =[
        'GET' => [],
        'POST' => []
    ];

    public function get(string $uri, string $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    
    public function post(string $uri, string $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function run(string $uri, string $method): void{

        if(array_key_exists($uri, $this->routes[$method])){

            $action = $this->routes[$method][$uri];

            list($controllerName, $methodName) = explode('@', $action);

            $controllerPath = __DIR__ .'/../Controller/' . $controllerName . '.php';

            echo "([URI=>$uri,Metodo=>$method,Action=>$action,ControllerPath=>$controllerPath])";

            if (file_exists($controllerPath)){
                require_once $controllerPath;

                $controllerInstance = new $controllerName();
                $controllerInstance->$methodName();
            }
            else{
                http_response_code(500);
                echo json_encode(["erro"=> "Erro interno Controller $controllerName não existe"]);
            }
        }else{
            http_response_code(404);
            echo json_encode(["erro" => "Rota 404 - Página ou Endpoint não encontrado."]);
        }
    }

    // public static function run(string $uri, string $method )
    // {
        
    //     switch ($uri) {
    //         case '/':
    //             echo "<h1>Bem-vindo ao Sistema Imobiliario</h1>";
    //             break;
    //         case '/imoveis':
    //             echo "<h1>Lista de Imóvies</h1>";
    //             break;
    //         case '/Corretores':
    //             echo "<h1>Lista de Corretores</h1>";
    //             break;
    //         case '/api/users':
    //             require_once __DIR__ . '/../Controller/AuthController.php';
    //             $authController = new AuthController();

    //             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //                 $authController->store();
    //             } else {
    //                 header('Content-Type: application/json');
    //                 http_response_code(405); // Method Not Allowed
    //                 echo json_encode(["erro" => "Apenas requisições POST são permitidas nesta rota."]);
    //             }
    //             break;
    //         default:
    //             http_response_code(404);
    //             echo "<h1>Erro 404</h1>";
    //             break;
    //     }
    // }
}

?>