<?php 

$title = "All our products";

$shoesImg = ROOT . "assets/images/categories/shoes.jpg";
$equipmentImg = ROOT . "assets/images/categories/equipment.jpg";

ob_start();?>
<div class="page__content categories">
    <div class="category-card">
        <img src="<?= $shoesImg ?>" alt="Awesome shoes">
        <h2>Shoes</h2>
    </div>
    <div class="category-card">
        <img src="<?= $equipmentImg ?>" alt="Awesome equipment">
        <h2>Equipment</h2>
    </div>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";