<?php

$title = "Sign up";

ob_start();?>
<div class="page__content signup">
    <form method="POST" class="signup__form form" novalidate>
        <?= !empty($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
        <div class="form__field">
            <label for="email">* Email:</label> 
            <input type="email" name="email" id="email" value="<?=$_POST["email"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="password">* Password:</label> 
            <input type="password" name="password" id="password" value="<?=$_POST["password"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="passwordConfirm">* Confirm password:</label> 
            <input type="password" name="passwordConfirm" id="passwordConfirm" value="<?=$_POST["passwordConfirm"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="firstName">First name:</label>
            <input type="text" name="firstName" id="firstName" value="<?=$_POST["firstName"] ?? ""?>"/>
        </div>
        <div class="form__field">
            <label for="lastName">Last name:</label>
            <input type="text" name="lastName" id="lastName" value="<?=$_POST["lastName"] ?? ""?>"/>
        </div>
        <button class="button" type="submit" name="submit">Sign up</button>
        <p class="has-account">Already have an account? <a href="<?=ROOT?>user/signin">Sign in</a></p>
    </form>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";