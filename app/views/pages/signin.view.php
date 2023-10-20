<?php

$title = "Sign in";
$errorMessage = $data["error"] ?? null;

ob_start();?>
<div class="page__content signin">
    <form method="POST" class="signin__form form" novalidate>
        <?= $errorMessage ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
        <div class="form__field">
            <label for="email">* Email:</label> 
            <input type="email" name="email" id="email" value="<?=$_POST["email"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="password">* Password:</label> 
            <input type="password" name="password" id="password" value="<?=$_POST["password"] ?? ""?>" required/>
        </div>
        <button class="button" type="submit" name="submit">Sign in</button>
        <p class="has-account">Not registered yet? <a href="<?=ROOT?>user/signup">Sign up</a></p>
    </form>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";