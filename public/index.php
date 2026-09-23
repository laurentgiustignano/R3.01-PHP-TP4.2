<?php

use Iutrds\Tp42\Router;

require '../vendor/autoload.php';

$router = new Router();
$resultat = $router->traiter($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

header('Content-Type: application/json');
http_response_code($resultat['code']);
echo json_encode($resultat['donnees'], JSON_PRETTY_PRINT);
