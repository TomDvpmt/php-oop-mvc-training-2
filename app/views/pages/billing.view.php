<?php

$title = "Billing info";

$chosen = $data["chosenAddress"] ?? null;

/* User's saved billing addresses */

if (isset($data["errorType"]) && $data["errorType"] === "addresses") {
    ob_start();
    require_once VIEWS_DIR . "partials/error.php";
    $addressesContent = ob_get_clean();
} elseif (empty($data["addresses"])) {
    $addressesContent = null;
}
else {
    $options = [];
    foreach($data["addresses"] as $key => $value) {
        $slug = htmlspecialchars($value["address_slug"]);
        $id = (string) "option-" . ($key + 1);
        $selected = $chosen && $chosen["address_slug"] === $slug ? "selected" : null;
        $options[] = "<option id='$id' value='$slug' $selected>$slug</option>";
    }
    $selected = $chosen ? null : "selected";
    $options[] = "<option value='' $selected>-- Create a new one --</option>";
    $billingAddressesOptions = implode("", $options);

    ob_start();?>
    <form class="billing__addresses form" method="POST" action="">
        <h2>Choose billing address</h2>
        <select name="addressOption" id="addressOption">
            <?= $billingAddressesOptions ?>
        </select>
        <button type="submit">Validate</button>
    </form>
    <?php $addressesContent = ob_get_clean();
}

/* Fill / clear form buttons */

ob_start();?>
<div class="form__fill-clear-buttons">
    <button type="button" id="billing-fill-button">Fill with demo data</button>
    <button type="button" id="billing-clear-button">Clear form</button>
</div>
<?php $fillClearButtons = ob_get_clean();


/* Save address checkbox & input */

ob_start();?>
<div class="form__field form__field--checkbox">
    <label for="save-address">Save this address ?</label>
    <input type="checkbox" name="save_address" id="save-address">
</div>
<div class="form__field" id="address-slug-field">
    <label for="address-slug-input">Give a name to this address:</label>
    <input type="text" name="address_slug" id="address-slug-input"><!-- TODO : required -->
</div>
<?php $saveAddressBlock = ob_get_clean();

/* Billing info form */

$billingFormContent = "";
$readOnly = $chosen ? "readonly" : null;

if (isset($_POST["addressOption"]) || $addressesContent === null) {
    ob_start();?>
    <form id="billing-form" class="billing__form form" action="<?= ROOT . "order?action=recap" ?>" method="POST">
        <?= $chosen ? null : $fillClearButtons ?>
        <div class="form__field">
            <label for="name">* Name: </label>
            <input type="text" name="name" id="name" class="billing-field" value="<?=$chosen["name"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="phone">* Phone: </label>
            <input type="phone" name="phone" id="phone" class="billing-field" value="<?=$chosen["phone"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="address">* Address: </label>
            <input type="text" name="address" id="address" class="billing-field" value="<?=$chosen["address"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="zipcode">* Zip code: </label>
            <input type="number" name="zipcode" id="zipcode" class="billing-field" value="<?=$chosen["zipcode"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="city">* City: </label>
            <input type="text" name="city" id="city" class="billing-field" value="<?=$chosen["city"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="country">* Country: </label>
            <input type="text" name="country" id="country" class="billing-field" value="<?=$chosen["country"] ?? null?>" <?=$readOnly?>><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="payment_type">* Payment type:</label>
            <select name="payment_type" id="payment_type" required> <!-- TODO : required -->
                <option id="payment-type-question" value="">-- How do you want to pay? --</option>
                <option value="library card">Library card</option>
                <option value="Monopoly bills">Monopoly bills</option>
                <option id="demo-payment-type" value="spice shipment">Spice shipment</option>
                <option value="the Force">I'll use the Force</option>
            </select>
        </div>
        <?= $chosen ? null : $saveAddressBlock ?>
        <input type="submit" value="Continue">
    </form>
    <?php $billingFormContent = ob_get_clean();
} else {
    $billingFormContent = null;
}


/* Main content */

ob_start();?>
<div class="page__content billing">
    <?= $addressesContent ?>
    <?= $billingFormContent ?>
</div>
<?php $content = ob_get_clean();

$jsFiles = [
    ROOT . "assets/js/billing.js"
];


require_once VIEWS_DIR . "/layout.php";