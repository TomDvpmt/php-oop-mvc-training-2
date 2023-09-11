<?php 

$title = "Equipment";

ob_start(); ?>

<div class="products">
    <section class="products__sidebar"></section>
    <section class='products__grid'><?= implode($data) ?></section>
</div>

<?php 

$content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";