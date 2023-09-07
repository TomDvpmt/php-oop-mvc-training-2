<?php 

$title = "Equipment";

ob_start(); ?>

<div class="products">
    <div class="products__sidebar"></div>
    <div class='products__grid'><?= implode($data) ?></div>
</div>

<?php 

$content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";