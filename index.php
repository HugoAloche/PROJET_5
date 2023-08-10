<?php

require_once __DIR__ . '/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

switch ($_SERVER['REQUEST_URI']) {
    case '/':
        echo $twig->render('index.html.twig');
        break;
    default:
        http_response_code(404);
        echo $twig->render('404.html.twig', ['url' => $_SERVER['REQUEST_URI']]);
        break;
}
