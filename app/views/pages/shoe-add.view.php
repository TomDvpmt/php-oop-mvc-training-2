<?php 

$title = "Add a shoe item";

ob_start(); ?>

<div class="page__content add-product">
    <form method="POST" class="form">
        <div class="form__field">
            <label for="name">Name :</label>
            <input type="text" name="name" />
        </div>
        <div class="form__field">
            <label for="description">Description :</label>
            <input type="text" name="description" />
        </div>
        <div class="form__field">
            <label for="price">Price :</label>
            <input type="number" name="price" min="0" />
        </div>
        <div class="form__field">
            <select name="waterproof" id="waterproof">
                <option value="">-- Is the shoe waterproof? --</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>
        <div class="form__field">
            <select name="level" id="level">
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
</div>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";