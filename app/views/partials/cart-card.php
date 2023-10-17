<?php

use PhpTraining2\models\products\Product; // TODO : full path compiling not in the view, but before

$generic = $item["genericData"];

?>

<article class="product-card product-card--cart" id="<?=$generic["id"]?>">
    <img class="product-card__img" src="<?=ROOT . Product::PRODUCTS_THUMBS_DIR . $generic["thumbnail"]?>" alt="<?=$generic["name"]?>">
    <h2 class="product-card__name"><?=$generic["name"]?></h2>
    <!-- insert specific -->
    <p class="product-card__price">$ <?=$generic["price"]?></p>
    <form method="POST" action="<?= ROOT . "cart?action=updateQuantity&id=" . $generic["id"]?>" class="product-card__quantity">
        <label for="quantity">Quantity: </label>
        <input type="number" name="quantity" id="quantity" min="1" value="<?= $item["quantity"]?>">
        <input type="submit" value="Update">
    </form>
    <p class="product-card__total">Total: $ <?= $generic["price"] * $item["quantity"] ?></p> <!-- Total to be upgraded with JavaScript -->
    <div class="product-card__controls">
        <a href="<?= ROOT . "cart?action=remove&id=" . $generic["id"] ?>">Remove</a>
    </div>
</article>