<?php 

$title = "Add a product";

$shoeSpecific = "";
$equipmentSpecific = "";

/** Specific HTML **/

switch ($this->productType) {
    case 'shoe':
        ob_start()?>
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
        <?php $shoeSpecific = ob_get_clean();
        break;

    case 'equipment':
        ob_start();?>
        <div class="form__field">
            <select name="activity" id="activity">
                <option value="">-- What is the activity domain of this equipment? --</option>
                <option value="hiking">Hiking</option>
                <option value="trail">Trail</option>
            </select>
        </div>
        <?php $equipmentSpecific = ob_get_clean();
        break;
    
    default:
        break;
}

/** Main form HTML **/

$specific = $shoeSpecific . $equipmentSpecific;

ob_start()?>

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
    <div class="form__specific-fields">
        <?= $specific ?>
    </div>
    <button class="button" type="submit" name="submit">Add product</button>
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <?php echo isset($successMessage) ? "<p class='success'>" . $successMessage . "</p>" : null ?>
</form>

<?php $mainForm = ob_get_clean();


/** Full HTML **/


ob_start(); ?>
<div class="page__content add-product">
    <form action="" method="GET" class="form">
        <input type="hidden" name="action" value="add"/>  
        <div class="form__field">
            <label for="type">Product type :</label>
            <select name="type" id="type" required>
                <option value="">-- Choose a product type --</option>
                <option value="shoe" <?= $this->productType === "shoe" ? "selected" : null?>>Shoe</option>
                <option value="equipment" <?= $this->productType === "equipment" ? "selected" : null?>>Equipment</option>
            </select>
        </div>
        <input type="submit" value="Validate">
    </form>
    <?= !empty($_GET["type"]) ? $mainForm : null ?>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";