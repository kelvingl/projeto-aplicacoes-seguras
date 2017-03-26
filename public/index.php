<?php

require "../vendor/autoload.php";

session_start();

$app = new \Slim\App;
$container = $app->getContainer();
$container['renderer'] = new \Slim\Views\PhpRenderer("../resources/view");
$container['db'] = function() {
    static $mysqli;
    if ($mysqli === null) {
        $mysqli = new mysqli('127.0.0.1', 'root', '', 'db');
    }
    return $mysqli;
};
$container['auth'] = function()
{
    if(!isset($_SESSION['grupo_admin'])) return null;
    return (int) $_SESSION['grupo_admin'];
};

$container["encodeData"] = function($container)
{
	return function ($str) use ($container)
	{
		return $container->db->real_escape_string(htmlspecialchars($str));
	};
};

$app->get('/', function ($request, $response) {return $response->withRedirect($this->router->pathFor('indexGet'));});

require "../src/chamados.php";
require "../src/grupos.php";
require "../src/usuarios.php";

$app->get('/unauthorized', function($request, $response) {
    die('unauthorized');
})->setName('unauthorized');

$app->run();