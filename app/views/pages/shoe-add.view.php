<?php 

$title = "Add a shoe item";

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
    <div class="form__field">
        <select name="product-waterproof" id="product-waterproof">
            <option value="">-- Is the shoe waterproof? --</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>
    <div class="form__field">
        <select name="product-level" id="product-level">
            <option value="">-- What is the practice level of this shoe? --</option>
            <option value="occasional">Occasional</option>
            <option value="regular">Regular</option>
            <option value="intensive">Intensive</option>
        </select>
    </div>
    <button class="button" type="submit" name="submit">Add shoe</button>
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <?php echo isset($successMessage) ? "<p class='success'>" . $successMessage . "</p>" : null ?>
</form>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";