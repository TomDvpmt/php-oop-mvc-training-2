<?php 

$title = "Oh no, a dead end!";

ob_start();?>

<div class="page__content error404">
    <p>The page you requested doesn't exist.</p>
    <a href="<?= ROOT ?>">Get back home safely</a>
</div>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";