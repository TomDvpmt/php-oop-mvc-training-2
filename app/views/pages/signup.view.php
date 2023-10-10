<?php

$title = "Sign up";
$formData = $data["formData"] ?? [];
$errors = $data["validationErrors"] ?? [];

ob_start();?>
<div class="page__content signup">
    <form method="POST" class="signup__form form" novalidate>
        <div class="form__field">
            <label for="email">* Email:</label> 
            <input type="email" name="email" id="email" value="<?=$formData["email"] ?? ""?>" required/>
            <?= !empty($errors["emailInvalid"]) ? "<p class='error'>" . $errors["emailInvalid"] . "</p>" : null ?>
            <?= !empty($errors["emailAlreadyUsed"]) ? "<p class='error'>" . $errors["emailAlreadyUsed"] . "</p>" : null ?>
        </div>
        <div class="form__field">
            <label for="password">* Password:</label> 
            <input type="password" name="password" id="password" value="<?=$formData["password"] ?? ""?>" required/>
            <?= !empty($errors["password"]) ? "<p class='error'>" . $errors["password"] . "</p>" : null ?>
        </div>
        <div class="form__field">
            <label for="passwordConfirm">* Confirm password:</label> 
            <input type="password" name="passwordConfirm" id="passwordConfirm" value="<?=$formData["passwordConfirm"] ?? ""?>" required/>
            <?= !empty($errors["passwordsDontMatch"]) ? "<p class='error'>" . $errors["passwordsDontMatch"] . "</p>" : null ?>
        </div>
        <div class="form__field">
            <label for="firstName">First name:</label>
            <input type="text" name="firstName" id="firstName" value="<?=$formData["firstName"] ?? ""?>"/>
            <?= !empty($errors["firstName"]) ? "<p class='error'>" . $errors["firstName"] . "</p>" : null ?>
        </div>
        <div class="form__field">
            <label for="lastName">Last name:</label>
            <input type="text" name="lastName" id="lastName" value="<?=$formData["lastName"] ?? ""?>"/>
            <?= !empty($errors["lastName"]) ? "<p class='error'>" . $errors["lastName"] . "</p>" : null ?>
        </div>
        <button class="button" type="submit" name="submit">Sign up</button>
        <?= !empty($errors["hasEmptyFields"]) ? "<p class='error'>" . $errors["hasEmptyFields"] . "</p>" : null ?>
        <p class="has-account">Already have an account? <a href="<?=ROOT?>user/signin">Sign in</a></p>
    </form>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";