<?php
  $name = isset($post['name']) ? $post['name'] : "";
  $category_id = isset($post['category_id']) ? $post['category_id'] : "";
  $description = isset($post['description']) ? $post['description'] : "";
  $start_price = isset($post['start_price']) ? $post['start_price'] : "";
  $price_step = isset($post['price_step']) ? $post['price_step'] : "";
  $date_end = isset($post['date_end']) ? $post['date_end'] : "";
?>
    <?php $classname_form = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form form--add-lot container <?=$classname_form; ?>" action="add.php" method="post" enctype="multipart/form-data">

      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?=$classname; ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" value="<?= $name; ?>" name="name" placeholder="Введите наименование лота">
           <?php if (isset($errors['name'])): ?>
              <span class="form__error"><?= $errors['name']; ?></span>
          <?php endif; ?>
        </div>

        <?php $classname = isset($errors['category_id']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?=$classname; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category_id">
            <option value="0">Выберите категорию</option>
             <?php foreach ($category as $val): ?>
                <option value="<?=$val['id']; ?>" <?= ($category_id === $val['id']) ? 'selected' : ''; ?>>
                    <?=$val['name']; ?>
                </option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($errors['category_id'])): ?>
            <span class="form__error"><?= $errors['category_id']; ?></span>
          <?php endif; ?>
        </div>
      </div>

      <?php $classname = isset($errors['description']) ? "form__item--invalid" : ""; ?>
      <div class="form__item form__item--wide <?= $classname; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $description; ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <span class="form__error"><?= $errors['description']; ?></span>
        <?php endif; ?>
      </div>

      <?php $classname = isset($errors['image']) ? "form__item--invalid" : ""; ?>
      <div class="form__item form__item--file <?= $classname; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="image">
          <label for="lot-img">
            Добавить
          </label>
        </div>
        <?php if (isset($errors['image'])): ?>
            <span class="form__error"><?= $errors['image']; ?></span>
        <?php endif; ?>
      </div>

      <div class="form__container-three">
        <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" value="<?= $start_price; ?>" name="start_price" placeholder="0">
          <?php if (isset($errors['start_price'])): ?>
                <span class="form__error"><?= $errors['start_price']; ?></span>
            <?php endif; ?>
        </div>

        <?php $classname = isset($errors['price_step']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" value="<?= $price_step; ?>" name="price_step" placeholder="0">
          <?php if (isset($errors['price_step'])): ?>
                <span class="form__error"><?= $errors['price_step']; ?></span>
            <?php endif; ?>
        </div>

        <?php $classname = isset($errors['date_end']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" value="<?= $date_end; ?>" name="date_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          <?php if (isset($errors['date_end'])): ?>
                <span class="form__error"><?= $errors['date_end']; ?></span>
            <?php endif; ?>
        </div>
      </div>

      <?php if (isset($errors)): ?>
          <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <?php endif; ?>
      <button type="submit" class="button">Добавить лот</button>
    </form>
