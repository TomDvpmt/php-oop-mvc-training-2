<?php 

$location = "home";
$title = "Home view";

ob_start();?>

<div class="page__content home">
    <p>Awesome content !</p>
</div>

<?php $content = ob_get_clean();


require_once VIEWS_DIR . "/layout.php";