<?php


session_start();

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/imoveis', 'ImovelController@listar');
$router->get('/corretores', 'CorretorController@listar');
$router->get('/api/users', 'AuthController@showAll');

$router->post('/api/users', 'AuthController@store');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->run($uri, $method);

?>