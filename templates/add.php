<nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($category as $value): ?>
          <li class="nav__item">
            <a href="all-lots.html"><?=htmlspecialchars($value['name']); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    
    <?php $classname_form = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form form--add-lot container <?=$classname_form; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
     
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
          $value = isset($name) ? $name : ""; ?>
        <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" value="<?= $value; ?>" name="name" placeholder="Введите наименование лота">
           <?php if (isset($errors['name'])): ?>
              <span class="form__error"><?= $errors['name']; ?></span>
          <?php endif; ?>
        </div>
        
        <?php $classname = isset($errors['category_id']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?=$classname; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category_id">
            <option>Выберите категорию</option>
             <?php foreach ($category as $val): ?>
               <?php $value = isset($category_id) ? $category['id'] : ""; ?>
                <option value="<?=$val['id']; ?>">
                    <?=$val['name']; ?>
                </option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($errors['category_id'])): ?>
            <span class="form__error"><?= $errors['category_id']; ?></span>
          <?php endif; ?>
        </div>
      </div>
      
      <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
      $value = isset($description) ? $description : ""; ?>
      <div class="form__item form__item--wide <?= $classname; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $value; ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <span class="form__error"><?= $errors['description']; ?></span>
        <?php endif; ?>
      </div>
      
      <?php $classname = isset($errors['image']) ? "form__item--invalid" : "";
      $value = isset($image) ? $image : ""; ?>
      <div class="form__item form__item--file <?= $classname; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="<?= $value; ?>" name="image">
          <label for="lot-img">
            Добавить
          </label>
        </div>
        <?php if (isset($errors['image'])): ?>
            <span class="form__error"><?= $errors['image']; ?></span>
        <?php endif; ?>
      </div>
        
      <div class="form__container-three">
        <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : "";
        $value = isset($start_price) ? $start_price : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" value="<?= $value; ?>" name="start_price" placeholder="0">
          <?php if (isset($errors['start_price'])): ?>
                <span class="form__error"><?= $errors['start_price']; ?></span>
            <?php endif; ?>
        </div>
        
        <?php $classname = isset($errors['price_step']) ? "form__item--invalid" : "";
        $value = isset($price_step) ? $price_step : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" value="<?= $value; ?>" name="price_step" placeholder="0">
          <?php if (isset($errors['price_step'])): ?>
                <span class="form__error"><?= $errors['price_step']; ?></span>
            <?php endif; ?>
        </div>
        
        <?php $classname = isset($errors['date_end']) ? "form__item--invalid" : "";
        $value = isset($date_end) ? $date_end : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" value="<?= $value; ?>" name="date_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
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