<?php 

$title = "Cart";

$grid = [];
foreach($data["items"] as $item) {
    ob_start();
    require VIEWS_DIR . "partials/cart-card.php";
    $card = ob_get_clean();
    $grid[] = $card;
}

$hasItems = !empty($data["items"]);

ob_start(); ?>
<div class="page__content cart">
    <div class="cart__grid"><?= !empty($grid) ? implode("", $grid) : "No product in cart." ?></div>
    <div class="cart__total">
        <span>TOTAL: </span><span><?="$ " . $data["totalPrice"] ?></span>
    </div>
    <button <?= $hasItems ? null : "disabled" ?>><a href="<?= $hasItems ? ROOT . "order?action=billing" : "" ?>">Order</a></button>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";