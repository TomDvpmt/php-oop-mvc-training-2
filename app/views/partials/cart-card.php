<article class="product-card product-card--cart" id="<?=$item["id"]?>">
    <img class="product-card__img" src="<?=$item["img_url"]?>" alt="<?=$item["name"]?>">
    <h2 class="product-card__name"><?=$item["name"]?></h2>
    <!-- insert specific -->
    <p class="product-card__price">$ <?=$item["price"]?></p>
    <form method="POST" action="<?= ROOT . "cart?action=updateQuantity&id=" . $item["id"]?>" class="product-card__quantity">
        <label for="quantity">Quantity: </label>
        <input type="number" name="quantity" id="quantity" min="1" value="<?= $item["quantity"]?>">
        <input type="submit" value="Update">
    </form>
    <p class="product-card__total">Total: $ <?= $item["price"] * $item["quantity"] ?></p> <!-- Total to be upgraded with JavaScript -->
    <div class="product-card__controls">
        <a href="<?= ROOT . "cart?action=remove&id=" . $item["id"] ?>">Remove</a>
    </div>
</article>