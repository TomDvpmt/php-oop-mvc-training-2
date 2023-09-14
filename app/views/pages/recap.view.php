<?php

$title = "Your order";
$billingGrid = [];
$itemsGrid = [];

foreach($data["billingInfo"] as $key => $value) {
    ob_start();?>
    <p class="recap__billing-info__field"><?=ucfirst($key)?>: <?=$value?></p>
    <?php $field = ob_get_clean();

    array_push($billingGrid, $field);
}

foreach($data["cart"] as $item) {
    ob_start();
    require VIEWS_DIR . "partials/recap-card.php";
    $card = ob_get_clean();

    array_push($itemsGrid, $card);
}



ob_start();?>
<div class="page__content recap">
    <section class="recap__billing-info">
        <h2>Billing info</h2>
        <?= implode("", $billingGrid) ?>
    </section>
    <section class="recap__cart">
        <h2>Products</h2>
        <?= implode("", $itemsGrid) ?>
        <p class="recap__cart__total">Total: $ <?=$data["totalPrice"]?></p>
    </section>
    <button><a href="<?= ROOT . "order?action=pay"?>">Pay</a></button>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";