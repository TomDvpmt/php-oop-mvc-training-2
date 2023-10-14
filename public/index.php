<?php 

declare(strict_types=1);

error_reporting(E_ALL); // TODO production
ini_set('display_errors', E_ALL); // TODO production

use PhpTraining2\core\App;

session_start();

require "../app/core/init.php";

$app = new App;
$app->initializeDB();
$app->loadRouter();