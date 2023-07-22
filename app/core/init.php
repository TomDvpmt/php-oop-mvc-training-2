<?php

use Dotenv\Dotenv;

require '../vendor/autoload.php';
$dotenv = Dotenv::createImmutable("..");
$dotenv->load();

require "config.php";
require "functions.php";
require "Database.php";
require "Model.php";
require "Controller.php";
require "App.php";




