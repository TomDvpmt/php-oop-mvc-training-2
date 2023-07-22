<?php

if($_SERVER["SERVER_NAME"] === "localhost") {
    define("ROOT", "http://localhost:4100/public/");
} else {
    define("ROOT", "https://www.example.com");
}

define("DB_HOST", $_SERVER["DB_HOST"]);
define("DB_NAME", $_SERVER["DB_NAME"]);
define("DB_USER", $_SERVER["DB_USER"]);
define("DB_PASSWORD", $_SERVER["DB_PASSWORD"]);
