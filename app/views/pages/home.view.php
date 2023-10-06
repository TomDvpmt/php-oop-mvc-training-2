<?php 

$location = "home";
$title = "Home view";
$jsFiles = [
    ROOT . "assets/js/disclaimer.js"
];

ob_start();?>

<div class="page__content home">
    <p>Awesome content !</p>
</div>

<?php $content = ob_get_clean();

if($_SESSION["disclaimer"] === true) require_once VIEWS_DIR . "partials/disclaimer.php";
require_once VIEWS_DIR . "/layout.php";