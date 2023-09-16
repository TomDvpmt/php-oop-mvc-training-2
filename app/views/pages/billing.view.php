<?php

$title = "Billing info";

ob_start();?>
<div class="page__content billing">
    <form class="billing__form form" action="<?= ROOT . "order?action=recap" ?>" method="POST">
        <div class="form__field">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="phone">Phone: </label>
            <input type="phone" name="phone" id="phone"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="address">Address: </label>
            <input type="text" name="address" id="address"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="zipcode">Zip code: </label>
            <input type="number" name="zipcode" id="zipcode"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="city">City: </label>
            <input type="text" name="city" id="city"><!-- TODO : required -->
        </div>
        <div class="form__field">
            <label for="country">Country: </label>
            <input type="text" name="country" id="country"><!-- TODO : required -->
        </div>
        <input type="submit" value="Continue">
    </form>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";