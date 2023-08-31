<?php 

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewsport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/public/assets/css/style.css">
        
        <title><?= $title . " | PHP Training" ?></title>
        
    </head>

<?php  

use PhpTraining2\core\App;

session_start();

require "../app/core/init.php";

$app = new App;
$app->loadController();

?>

</html>