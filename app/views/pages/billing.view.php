<?php

$title = "Billing info";


/* User registered billing addresses */

if (isset($data["errorType"]) && $data["errorType"] === "addresses") {
    ob_start();
    require_once VIEWS_DIR . "partials/error.php";
    $addressesContent = ob_get_clean();
} elseif (empty($data)) {
    $addressesContent = null;
}
else {

    $billingAddressesOptions = implode("", array_map(
        fn($address) => "<option value=" . $address["address_slug"] . ">Library card</option>", 
        $data
    ));

    ob_start();?>
    <div class="billing__addresses">
   
        <h2>Choose billing info</h2>
        <select name="addresses" id="addresses" required>
            <?= $billingAddressesOptions ?>
        </select>

    </div>
    <?php $addressesContent = ob_get_clean();
}


/* Main content */

ob_start();?>
<div class="page__content billing">
    <?= $addressesContent ?>
    <form id="billing-form" class="billing__form form" action="<?= ROOT . "order?action=recap" ?>" method="POST">
        <button type="button" id="billing-fill-button">Fill with demo data</button>
        <button type="button" id="billing-clear-button">Clear form</button>
        <div class="form__field">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="phone">Phone: </label>
            <input type="phone" name="phone" id="phone" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="address">Address: </label>
            <input type="text" name="address" id="address" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="zipcode">Zip code: </label>
            <input type="number" name="zipcode" id="zipcode" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="city">City: </label>
            <input type="text" name="city" id="city" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="country">Country: </label>
            <input type="text" name="country" id="country" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="payment_type">Payment type:</label>
            <select name="payment_type" id="payment_type" required> <!-- TODO : required -->
                <option id="payment-type-question"value="">-- How do you want to pay? --</option>
                <option value="library card">Library card</option>
                <option value="Monopoly bills">Monopoly bills</option>
                <option id="demo-payment-type" value="spice shipment">Spice shipment</option>
                <option value="the Force">I'll use the Force</option>
            </select>
        </div>
        <div class="form__field form__field--checkbox">
            <label for="save-address">Save this address ?</label>
            <input type="checkbox" name="save_address" id="save-address">
        </div>
        <div class="form__field" id="address-slug-field">
            <label for="address-slug-input">Give a name to this address:</label>
            <input type="text" name="address_slug" id="address-slug-input"><!-- TODO : required -->
        </div>
        <input type="submit" value="Continue">
    </form>
</div>
<?php $content = ob_get_clean();

$jsFiles = [
    ROOT . "assets/js/billing.js"
];


require_once VIEWS_DIR . "/layout.php";