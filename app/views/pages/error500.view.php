<?php 

$title = "Oh no.";

ob_start();?>

<div class="page__content error500">
    <p><?= $data["error"] ?? "Something went terribly wrong." ?></p>
    <a href="<?= ROOT ?>">Get back home safely</a>
</div>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";