<article class="recap-card" id="<?=$item["id"]?>">
    <img src="<?=$item["img_url"]?>" alt="<?=$item["name"]?>">
    <h3 class="recap-card__name"><?=$item["name"]?></h3>
    <!-- insert specific -->
    <p class="recap-card__price">$ <?=$item["price"]?></p>
    <p class="recap-card__quantity">Quantity: <?= $item["quantity"]?></p>
    <p class="recap-card__total">Total: $ <?= $item["price"] * $item["quantity"] ?></p>
</article>