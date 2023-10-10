<?php

use Dotenv\Dotenv;

require_once '../vendor/autoload.php';
$dotenv = Dotenv::createImmutable("..");
$dotenv->load();

require_once "config.php";
require_once "functions.php";




