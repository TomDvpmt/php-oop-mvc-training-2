<?php 

$title = "Add an equipment item";

ob_start(); ?>

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
        <select name="activity" id="activity">
            <option value="">-- What is the activity domain of this equipment? --</option>
            <option value="hiking">Hiking</option>
            <option value="trail">Trail</option>
        </select>
    </div>
    <button class="button" type="submit" name="submit">Add equipment</button>
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <?php echo isset($successMessage) ? "<p class='success'>" . $successMessage . "</p>" : null ?>
</form>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";