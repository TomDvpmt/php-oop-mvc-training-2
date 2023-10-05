<?php

use Dotenv\Dotenv;

require_once '../vendor/autoload.php';
$dotenv = Dotenv::createImmutable("..");
$dotenv->load();

require_once "config.php";
require_once "functions.php";
require_once "Database.php";
require_once "Model.php";
require_once "Controller.php";
require_once "Route.php";
require_once "Router.php";
require_once "App.php";




