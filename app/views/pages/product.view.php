<?php

$title = $data["name"];

$shoeSpecific = "";
$equipmentSpecific = "";

/** Specific html **/

switch ($this->type) {
    case 'shoe':
        ob_start();?>
        <p class="product-card__waterproof">Waterproof : <?= $data["waterproof"] === 0 ? "no" : "yes" ?></p>
        <p class="product-card__level">Level : <?= $data["level"] ?></p>
        <?php $shoeSpecific = ob_get_clean();
        break;

    case 'equipment':
        ob_start();?>
        <p class="product-card__activity">Activity : <?= $data["activity"] ?></p>
        <?php $equipmentSpecific = ob_get_clean();
    
    default:
        break;
}


/** Full html **/

$specific = $shoeSpecific . $equipmentSpecific;

ob_start();?>
<div class="page__content product" id="<?=$this->id?>">
    <img src="<?=$data["img_url"]?>" alt="<?=$data["name"]?>">
    <h2 class="product-card__name"><?=$data["name"]?></h2>
    <p class="product-card__description"><?=$data["description"]?></p>
    <div class="product-card__specific">
        <?= $specific ?>
    </div>
    <p class="product-card__price">$ <?=$data["price"]?></p>
    <div class="product-card__controls">
        <a href="<?= ROOT . "products?action=remove&type=$this->type&id=$this->id"?>">Delete</a>
    </div>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";