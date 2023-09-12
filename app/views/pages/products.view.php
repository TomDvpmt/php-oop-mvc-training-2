<?php 
$category = $this->category;
$title = $category === "" ? "All our products" : ucfirst($category) . "s";

ob_start();?>
<div>Shoes</div>
<div>Equipment</div>
<?php $allCategoriesContent = ob_get_clean();

ob_start(); ?>
<section class="products__sidebar"></section>
<section class='products__grid'><?= implode($data) ?></section>
<?php $categoryContent = ob_get_clean();

ob_start();?>
<div class="page__content products">
    <?= $category === "" ? $allCategoriesContent : $categoryContent ?>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";