<?php
ob_start();
session_start();

require('./comp/header.php');

$request = $_SERVER['REQUEST_URI'];
$uri = parse_url($request, PHP_URL_PATH);

switch ($uri) {
    case '/':
       require (__DIR__.'/pages/homepage.php');
        break;
    case '/conducteur':
        require (__DIR__.'/pages/conducteur.php');
        break;
    case '/stats':
        require (__DIR__.'/pages/stats.php');
        break;
    case '/vehicule':
        require (__DIR__.'/pages/vehicule.php');
        break;
    case '/association':
        require (__DIR__.'/pages/association.php');
        break;
    default:
        require(__DIR__ . '/pages/homepage.php');
        break;
}
require('./comp/footer.php');

ob_end_flush();
