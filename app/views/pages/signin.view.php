<?php

$title = "Sign in";

ob_start();?>
<div class="page__content signin">
    <p>Awesome signin form</p>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";