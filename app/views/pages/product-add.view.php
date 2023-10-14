<?php 

$title = "Add a product";

$errorMessage = $data["error"] ?? null;

ob_start()?>

<form action="" method="POST" enctype="multipart/form-data" class="form" >
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <div class="form__field">
        <label for="name">* Name:</label>
        <input type="text" name="name" id="name" value="<?=$_POST["name"] ?? ""?>"/>
    </div>
    <div class="form__field">
        <label for="description">* Description:</label>
        <input type="text" name="description" id="description" value="<?=$_POST["description"] ?? ""?>"/>
    </div>
    <div class="form__field">
        <label for="special_features">Special features:</label>
        <input type="text" name="special_features" id="special_features" value="<?=$_POST["special_features"] ?? ""?>"/>
    </div>
    <div class="form__field">
        <label for="limitations">Limitations:</label>
        <input type="text" name="limitations" id="limitations" value="<?=$_POST["limitations"] ?? ""?>"/>
    </div>
    <div class="form__field">
        <label for="price">* Price:</label>
        <input type="number" name="price" min="1" id="price" value="<?=$_POST["price"] ?? ""?>"/>
    </div>
    <div class="form__specific-fields">
        <?= $data["specificAddFormHtml"] ?>
    </div>
    <div class="form__field">
        <label for="thumbnail">Image:</label>
        <input type="file" name="thumbnail" id="thumbnail"/>
    </div>
    <button class="button" type="submit" name="submit">Add product</button>
</form>

<?php $mainForm = ob_get_clean();


/** Full HTML **/

ob_start(); ?>
<div class="page__content add-product">
    <form action="" method="GET" class="form">
        <?php echo isset($successMessage) ? "<p class='success'>" . $successMessage . "</p>" : null ?>
        <!-- <input type="hidden" name="action" value="add"/>   -->
        <div class="form__field">
            <label for="category">Product category :</label>
            <select name="category" id="category" required>
                <option value="">-- Choose a product category --</option>
                <option value="books" <?= $this->category === "books" ? "selected" : null?>>Book</option>
                <option value="protection" <?= $this->category === "protection" ? "selected" : null?>>Protection</option>
                <option value="shoes" <?= $this->category === "shoes" ? "selected" : null?>>Shoe</option>
                <option value="vehicles" <?= $this->category === "vehicles" ? "selected" : null?>>Vehicle</option>
                <option value="weapons" <?= $this->category === "weapons" ? "selected" : null?>>Weapon</option>
            </select>
        </div>
        <input type="submit" value="Validate">
    </form>
    <?= !empty($_GET["category"]) ? $mainForm : null ?>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";