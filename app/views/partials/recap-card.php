<?php

use PhpTraining2\models\products\Product;

$totalPrice = $item["genericData"]["price"] * $item["quantity"];

?>

<article class="recap-card" id="<?=$item["genericData"]["id"]?>">
    <img src="<?=ROOT . Product::PRODUCTS_THUMBS_DIR . $item["genericData"]["thumbnail"]?>" alt="<?=$item["genericData"]["name"]?>">
    <h3 class="recap-card__name"><?=$item["genericData"]["name"]?></h3>
    <!-- insert specific -->
    <p class="recap-card__price">$ <?=$item["genericData"]["price"]?></p>
    <p class="recap-card__quantity">Quantity: <?= $item["quantity"]?></p>
    <p class="recap-card__total">Total: $ <?= $totalPrice ?></p>
</article>