<?php

$title = "Billing info";

ob_start();?>
<div class="page__content billing">
    <form id="billing-form" class="billing__form form" action="<?= ROOT . "order?action=recap" ?>" method="POST">
        <button type="button" id="billing-fill-button">Fill with demo data</button>
        <div class="form__field">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" class="billing-field"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" class="billing-field"><!-- TODO : required -->
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
        <input type="submit" value="Continue">
    </form>
</div>
<?php $content = ob_get_clean();

$jsFiles = [
    ROOT . "assets/js/billing.js"
];

require_once VIEWS_DIR . "/layout.php";