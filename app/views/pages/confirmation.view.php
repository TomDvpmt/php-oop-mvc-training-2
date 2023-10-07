<?php 

$title = "Thank you for ordering our non-existent products.";

$orderId = $data["orderId"];

ob_start(); ?>
<div class="page__content confirmation">
    <p>Your imaginary items will be shipped in no time.</p>
    <p>To ease your excruciating wait, have fun memorizing this beautiful order id:</p>
    <p><?= $orderId ?></p>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";