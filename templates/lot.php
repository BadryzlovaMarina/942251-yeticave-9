<section class="lot-item container">
<?php foreach ($lot_list as $lot): ?>
  <h2><?=htmlspecialchars($lot['title']); ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$lot['image']; ?>" width="730" height="548" alt="Сноуборд">
      </div>
      <p class="lot-item__category"><?=htmlspecialchars($lot['category']); ?></p>
      <p class="lot-item__description"><?=htmlspecialchars($lot['description']); ?></p>
    </div>
    <div class="lot-item__right">
    <?php if (isset($_SESSION["user"])):?>
        <div class="lot-item__state">
        <div class="lot-item__timer timer <?=format_time($lot["date_end"])<='01:00:00' ? "timer--finishing" : ""; ?>">
            <?= format_time($lot["date_end"]); ?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=format_cost($lot['start_price']); ?></span>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?=format_cost($lot['min_price']); ?></span>
          </div>
        </div>
        <form class="lot-item__form" action=" " method="post" autocomplete="off">
          <p class="lot-item__form-item form__item <?=isset($errors['bet_price']) ? "form__item--invalid" : ""; ?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="bet_price" placeholder="12 000">
            <?php if (isset($errors['bet_price'])): ?>
                <span class="form__error"><?= $errors['bet_price']; ?></span>
            <?php endif; ?>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
        </div>
    <?php endif;?>
      <div class="history">
        <h3>История ставок (<span><?= $count_bets; ?></span>)</h3>
        <table class="history__list">
           <?php foreach ($last_bets as $bet): ?>
            <tr class="history__item">
                <td class="history__name"><?=htmlspecialchars($bet['name']); ?></td>
                <td class="history__price"><?=$bet['bet_price']; ?></td>
                <td class="history__time"><?=time_bets($bet['bet_date']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</section>