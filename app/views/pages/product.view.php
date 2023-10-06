<?php

$title = $data["name"];

show($data);

$shoeSpecific = "";
$equipmentSpecific = "";

/** Specific html **/

switch ($this->category) {
    case 'shoe':
        ob_start();?>
        <p class="product-card__waterproof">Waterproof: <?= $data["waterproof"] === 0 ? "no" : "yes" ?></p>
        <p class="product-card__level">Level: <?= $data["level"] ?></p>
        <?php $shoeSpecific = ob_get_clean();
        break;

    case 'equipment':
        ob_start();?>
        <p class="product-card__activity">Activity: <?= $data["activity"] ?></p>
        <?php $equipmentSpecific = ob_get_clean();
    
    default:
        break;
}


/** Full html **/

$specific = $shoeSpecific . $equipmentSpecific;

ob_start();?>
<div class="page__content product" id="<?=$this->id?>">
    <img class="product__img" src="<?=$data["img_url"]?>" alt="<?=$data["name"]?>">
    <h2 class="product__name"><?=$data["name"]?></h2>
    <p class="product__description"><?=$data["description"]?></p>
    <div class="product__specific">
        <?= $specific ?>
    </div>
    <p class="product__price">$ <?=$data["price"]?></p>
    <div class="product__controls">
        <a href="<?= ROOT . "cart?action=add&category=$this->category&id=$this->id" ?>">Add to cart</a>
        <a href="<?= ROOT . "products?action=remove&category=$this->category&id=$this->id"?>">Delete product</a>
    </div>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";