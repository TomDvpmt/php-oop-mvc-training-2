<article class="cart-card" id="<?=$item["id"]?>">
    <img src="<?=$item["img_url"]?>" alt="<?=$item["name"]?>">
    <h2 class="cart-card__name"><?=$item["name"]?></h2>
    <!-- insert specific -->
    <p class="cart-card__price">$ <?=$item["price"]?></p>
    <p class="cart-card__quantity">Quantity : </p>
    <p class="cart-card__total">Total : </p>
    <div class="cart-card__controls">
        <a href="<?= ROOT . "cart?action=remove&id=" . $item["id"] ?>">Remove</a>
    </div>
</article>