<?php 

$title = "Add a product";

ob_start(); ?>

<form method="POST" class="form">
    <div class="form__field">
        <label for="product-name">Name :</label>
        <input type="text" name="product-name" />
    </div>
    <div class="form__field">
        <label for="product-description">Description :</label>
        <input type="text" name="product-description" />
    </div>
    <div class="form__field">
        <label for="product-price">Price :</label>
        <input type="number" name="product-price" min="0" />
    </div>
    <button class="button" type="submit" name="submit">Add product</button>
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <?php echo isset($successMessage) ? "<p class='success'>" . $successMessage . "</p>" : null ?>
</form>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";