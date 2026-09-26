<?php

date_default_timezone_set('Europe/Paris');
session_start();

/** Dossier racine du site */
const ROOT_PATH = __DIR__;

/** URL racine du site */
const BASE_URL = 'http://localhost/ecommerce';

/** Controller par défaut (page d'acceuil du site) */
const DEFAULT_CONTROLLER = 'Home';

/** Action par défaut du site (affichage de la page d'acceuil) */
const DEFAULT_ACTION = 'showMainPage';

require_once ROOT_PATH . '/autoload.php';

$controller = $_GET['controller'] ?? DEFAULT_CONTROLLER;
$action = $_GET['action'] ?? DEFAULT_ACTION;
$controller = ucfirst($controller);

/** @var array<string, mixed> $params Liste des autres paramètres GET */
$params = array();
foreach($_GET as $key => $value)
{
    if($key != 'controller' && $key != 'action')
    {
        $params[$key] = $value;
    }
}

$controller .= 'Controller';
$filename = ROOT_PATH . '/controllers/' . $controller . '.php';

if(file_exists($filename))
{
    require_once $filename;
    if(method_exists($controller, $action))
    {
        $controller::$action($params);
    }
    else
    {
        print_r("L'action n'existe pas.");
    }
}
else
{
    print_r("Le controller n'existe pas.");
}