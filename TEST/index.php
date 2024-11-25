<?php

require 'Request.php';
require 'Response.php';
require 'Router.php';

use Framework\Request;
use Framework\Response;
use Framework\Router;

$request = new Request();
$response = new Response();
$router = new Router();

$router->get('/', function (Request $req, Response $res) {
    $res->setBody('Welcome to the home page!');
    $res->send();
});

$router->get('/about', function (Request $req, Response $res) {
    $res->setBody('This is the about page.');
    $res->send();
});

$router->setNotFoundHandler(function (Request $req, Response $res) {
    $res->setStatusCode(404);
    $res->setBody('Custom 404 page.');
    $res->send();
});

$router->dispatch($request, $response);
