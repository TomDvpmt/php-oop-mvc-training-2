<?php

$title = "Register";

ob_start();?>
<div class="page__content register">
    <form method="POST" class="register__form form" novalidate>
        <div class="form__field">
            <label for="email">* Email:</label> 
            <input type="email" name="email" id="email" value="<?=$data["email"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="password">* Password:</label> 
            <input type="password" name="password" id="password" value="<?=$data["password"] ?? ""?>" required/>
        </div>
        <div class="form__field">
            <label for="passwordConfirm">* Confirm password:</label> 
            <input type="password" name="passwordConfirm" id="passwordConfirm" required/>
        </div>
        <div class="form__field">
            <label for="firstName">First name:</label>
            <input type="text" name="firstName" id="firstName" value="<?=$data["firstName"] ?? ""?>"/>
        </div>
        <div class="form__field">
            <label for="lastName">Last name:</label>
            <input type="text" name="lastName" id="lastName" value="<?=$data["lastName"] ?? ""?>"/>
        </div>
        <button class="button" type="submit" name="submit">Register</button>
        <?= isset($errorMessage) ? "<p class='error'>" . $errorMessage . "</p>" : null ?>
        <p class="has-account">Already have an account? <a href="<?=ROOT?>login">Log in</a></p>
    </form>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";