<?php
    $name = isset($post['name']) ? $post['name'] : "";
    $email = isset($post['email']) ? $post['email'] : "";
    $password = isset($post['password']) ? $post['password'] : "";
    $contact = isset($post['contact']) ? $post['contact'] : "";
?>
<?php $classname_form = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname_form; ?>" action="sign-up.php" method="post" autocomplete="off"> <!-- form--invalid -->
   
    <h2>Регистрация нового аккаунта</h2>
    <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" value="<?= $email; ?>" name="email" placeholder="Введите e-mail">
        <?php if (isset($errors['email'])): ?>
        <span class="form__error"><?= $errors['email']; ?></span>
        <?php endif; ?>
    </div>
    
    <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" value="<?= $password; ?>" name="password" placeholder="Введите пароль">
        <?php if (isset($errors['password'])): ?>
        <span class="form__error"><?= $errors['password']; ?></span>
        <?php endif; ?>
    </div>
    
    <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" value="<?= $name; ?>" name="name" placeholder="Введите имя">
        <?php if (isset($errors['name'])): ?>
        <span class="form__error"><?= $errors['name']; ?></span>
        <?php endif; ?>
    </div>
    
    <?php $classname = isset($errors['contact']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" value="<?= $contact; ?>" name="contact" placeholder="Напишите как с вами связаться"></textarea>
        <?php if (isset($errors['contact'])): ?>
        <span class="form__error"><?= $errors['contact']; ?></span>
        <?php endif; ?>
    </div>
    
    <?php if (isset($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>