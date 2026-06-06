<?php


session_start();

require_once __DIR__ . '/../app/core/Router.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

Router::run($uri, $method);

?>