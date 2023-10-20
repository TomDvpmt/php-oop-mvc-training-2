<?php

$title = "My info";

$profileKeys = array_map(fn($key) => "<span class='user-info__profile__grid__key'>" . ucfirst(str_replace("_", " ", $key)) . "</span>", array_keys($data));
$profileValues = array_map(fn($value) => "<span class='user-info__profile__grid__value'>$value</span>", array_values($data));
$profileGrid = implode("", array_merge($profileKeys, $profileValues));

$billingAddressesGrid = ""; // TODO

if(isset($data["error"])) {
    ob_start();?>
    <div class="page__content user-info">
        <?php require_once VIEWS_DIR . "partials/error.php"?>
    </div>
    <?php $content = ob_get_clean();
} else {
    ob_start();?>
    <div class="page__content user-info">
        <div class="user-info__profile">
            <div class="user-info__profile__grid">
                <?=$profileGrid?>
            </div>
            <button type="button">Change info</button>
            <button type="button">Change password</button>
        </div>
        <div class="user-info__billing-addresses">
            <button type="button" id="show-billing-addresses-button">Show billing addresses</button>
            <div class="user-info__billing-addresses__grid">
                <?=$billingAddressesGrid?>
            </div>
        </div>
        <p><a href="<?=ROOT . "user/orders"?>">See my orders</a></p>
    </div>
    <?php $content = ob_get_clean();
}

require_once VIEWS_DIR . "/layout.php";