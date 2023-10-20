<?php

$title = "Your order";
show($_POST);
$billingGrid = [];
$itemsGrid = [];

foreach($data["billingInfo"] as $key => $value) {
    $formatedKey = ucfirst(str_replace("_", " ", $key));
    ob_start();?>
    <p class="recap__billing-info__field"><?=ucfirst($formatedKey)?>: <?=$value?></p>
    <?php $field = ob_get_clean();
    $billingGrid[] = $field;
}

foreach($data["items"] as $item) {
    ob_start();
    require VIEWS_DIR . "partials/recap-card.php";
    $card = ob_get_clean();
    $itemsGrid[] = $card;
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
        <p class="recap__cart__total">CART TOTAL: $ <?=$data["totalPrice"]?></p>
    </section>
    <button><a href="<?= ROOT . "order?action=confirm"?>">Pay</a></button>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";