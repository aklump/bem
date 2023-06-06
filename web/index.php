<?php
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__);
$twig = new \Twig\Environment($loader);
$twig->addExtension(new \AKlump\Bem\Twig\BemExtension());
$template = $twig->load('example.html.twig');
echo $template->render();
