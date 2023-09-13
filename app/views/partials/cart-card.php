<article class="cart-card" id="<?=$item["id"]?>">
    <img src="<?=$item["img_url"]?>" alt="<?=$item["name"]?>">
    <h2 class="cart-card__name"><?=$item["name"]?></h2>
    <!-- insert specific -->
    <p class="cart-card__price">$ <?=$item["price"]?></p>
    <form method="POST" action="<?= ROOT . "cart?action=updateQuantity&id=" . $item["id"]?>" class="cart-card__quantity">
        <label for="quantity">Quantity: </label>
        <input type="number" name="quantity" id="quantity" min="1" value="<?= $item["quantity"]?>">
        <input type="submit" value="Validate">
    </form>
    <p class="cart-card__total">Total: $ <?= $item["price"] * $item["quantity"] ?></p> <!-- Total to be upgraded with JavaScript -->
    <div class="cart-card__controls">
        <a href="<?= ROOT . "cart?action=remove&id=" . $item["id"] ?>">Remove</a>
    </div>
</article>