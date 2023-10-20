<?php

$title = "My orders";

ob_start();?>
<div class="page__content user-orders">
    <!-- TODO -->
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";