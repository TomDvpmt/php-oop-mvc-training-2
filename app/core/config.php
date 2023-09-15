<?php

if($_SERVER["SERVER_NAME"] === "localhost") {
    define("ROOT", "http://localhost:4100/public/");
} else {
    define("ROOT", "https://www.example.com");
}

// define database
define("DB_HOST", $_SERVER["DB_HOST"]);
define("DB_NAME", $_SERVER["DB_NAME"]);
define("DB_USER", $_SERVER["DB_USER"]);
define("DB_PASSWORD", $_SERVER["DB_PASSWORD"]);

// define main folders paths
$rootDir = ($_SERVER["DOCUMENT_ROOT"]);
define("VIEWS_DIR", $rootDir . "/app/views/");
define("CTRL_DIR", $rootDir . "/app/controllers/");
define("MODELS_DIR", $rootDir . "/app/models/");
