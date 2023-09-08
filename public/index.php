<?php 

declare(strict_types=1);

use PhpTraining2\core\App;

session_start();

require "../app/core/init.php";

$app = new App;
$app->initializeDB();
$app->loadController();