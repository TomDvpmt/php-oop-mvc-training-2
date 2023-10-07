<?php 

$title = "Add a product";

$specifics = [
    "books" => "",
    "protection" => "",
    "shoes" => "",
    "vehicules" => "",
    "weapons" => ""
];

/** Specific HTML **/

switch ($this->category) {
    case 'books':
        ob_start()?>
        <div class="form__field">
            <select name="genre" id="genre">
                <option value="">-- Which genre better defines this book? --</option>
                <option value="based on true events">Based on true events</option>
                <option value="fantasy">Fantasy</option>
                <option value="myth">Myth</option>
                <option value="science-fiction">Science-fiction</option>
                <option value="it's a blend">It's a blend</option>
            </select>
        </div>
        <?php $specifics["books"] = ob_get_clean();
        break;

    case 'protection':
        ob_start()?>
        <div class="form__field">
            <select name="type" id="type">
                <option value="">-- What kind of protection is this beauty? --</option>
                <option value="helmet">Helmet</option>
                <option value="armor">Armor</option>
                <option value="clothing">Clothing</option>
                <option value="plot armor">Plot armor</option>
                <option value="it's hard to say">It's hard to say</option>
            </select>
        </div>
        <div class="form__field">
            <select name="resistance" id="resistance">
                <option value="">-- How resistant is it? --</option>
                <option value="the dangerously weak kind">The dangerously weak kind</option>
                <option value="medium">Medium</option>
                <option value="it's an impenetrable wall">It's an impenetrable wall</option>
            </select>
        </div>
        <?php $specifics["protection"] = ob_get_clean();
        break;

    case 'shoes':
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
        <?php $specifics["shoes"] = ob_get_clean();
        break;
    
    case 'vehicles':
        ob_start()?>
        <div class="form__field">
            <select name="airborne" id="airborne">
                <option value="">-- Can it fly? --</option>
                <option value="don't try it!">Don't try it!</option>
                <option value="occasionally">Occasionally</option>
                <option value="oh yeah">Oh yeah</option>
            </select>
        </div>
        <div class="form__field">
            <select name="aquatic" id="aquatic">
                <option value="">-- Is it aquatic? --</option>
                <option value="we don't know, you should try it! (no refund)">We don't know, you should try it! (no refund)</option>
                <option value="reasonnably">Reasonnably</option>
                <option value="definitely">Definitely</option>
            </select>
        </div>
        <?php $specifics["vehicles"] = ob_get_clean();
        break;

    case 'weapons':
        ob_start()?>
        <div class="form__field">
            <select name="ideal_range" id="ideal_range">
                <option value="">-- What is the ideal range for this weapon? --</option>
                <option value="way too short">Way too short</option>
                <option value="medium">Mid-range</option>
                <option value="a cowardly yet comfortable long distance">A cowardly yet comfortable long distance</option>
            </select>
        </div>
        <?php $specifics["weapons"] = ob_get_clean();
        break;
    default:
        break;
}

/** Main form HTML **/

$specific = implode("", array_values($specifics));

ob_start()?>

<form method="POST" class="form">
    <?php echo isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
    <div class="form__field">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"/>
    </div>
    <div class="form__field">
        <label for="description">Description:</label>
        <input type="text" name="description" id="description"/>
    </div>
    <div class="form__field">
        <label for="special_features">Special features:</label>
        <input type="text" name="special_features" id="special_features"/>
    </div>
    <div class="form__field">
        <label for="limitations">Limitations:</label>
        <input type="text" name="limitations" id="limitations"/>
    </div>
    <div class="form__field">
        <label for="price">Price:</label>
        <input type="number" name="price" min="0" id="price"/>
    </div>
    <div class="form__specific-fields">
        <?= $specific ?>
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