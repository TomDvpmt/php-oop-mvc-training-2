<?php

$title = "Log in";

ob_start();?>
<div class="page__content login">
    <p>Awesome login form</p>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";