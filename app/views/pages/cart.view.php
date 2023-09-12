<?php 

$title = "Cart";

ob_start(); ?>

<div class="page__content cart">
    <p>Awesome cart !</p>
</div>

<?php 

$content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";