<?php

use PhpTraining2\models\products\Product;

$title = "Product";

if(isset($data["error"])) {
    
    ob_start();?>
    <div class="page__content product">
        <?php require_once VIEWS_DIR . "partials/error.php"?>
    </div>
    <?php $content = ob_get_clean();

} else {
    
    $generic = $data["genericData"];
    $title = $generic["name"];

    $thumbnailPath = ROOT. Product::PRODUCTS_THUMBS_DIR . $generic["thumbnail"]; // TODO : full path compiling not in the view, but before

    $specific = [];
    foreach ($data["specificData"] as $key => $value) {
        $label = ucfirst($key);
        $answer = $value["answer"];
        $specific[] = "<p class='product-card__$key'>$label: $answer</p>";
    }
    $specificHtml = implode("", $specific);

    ob_start();?>
    <div class="page__content product" id="<?=$generic["id"]?>">
        <img class="product__img" src="<?=$thumbnailPath?>" alt="<?=$generic["name"]?>">
        <h2 class="product__name"><?=$generic["name"]?></h2>
        <p class="product__description"><?=$generic["description"]?></p>
        <p class="product__special_features">Special features: <?=$generic["special_features"]?></p>
        <p class="product__limitations">Limitations: <?=$generic["limitations"]?></p>
        <div class="product__specific">
            <?= $specificHtml ?>
        </div>
        <p class="product__price">$ <?=$generic["price"]?></p>
        <div class="product__controls">
            <a href="<?= ROOT . "cart?action=add&category=" . $generic["category"] . "&id=" . $generic["id"]?>">Add to cart</a>
            <a href="<?= ROOT . "products/remove?category=" . $generic["category"] . "&id=" . $generic["id"]?>">Delete product</a>
        </div>
    </div>
    <?php $content = ob_get_clean();
}


require_once VIEWS_DIR . "/layout.php";