<section class="lots">
    <h2>Все лоты в категории <span><?= $category_name; ?></span></h2>
    <ul class="lots__list">
     <?php foreach ($lots as $key => $item): ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $item['image']; ?>" width="350" height="260" alt="Сноуборд">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?=htmlspecialchars($item['title']); ?></span>
          <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= $item['id_l']; ?>"><?=htmlspecialchars($item['title']); ?></a></h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount"><?php if ($item['MAX(b.bet_price)'] !== null) echo 'Ставок ' . $item['count(b.id)']; else echo 'Стартовая цена'; ?></span>
              <span class="lot__cost"><?php if ($item['MAX(b.bet_price)'] !== null) echo format_cost($item['MAX(b.bet_price)']); else echo format_cost($item['start_price']); ?></span>
            </div>
            <?php if (strtotime($item['date_end']) > time()) : ?>
            <div class="lot__timer timer <?=format_time($item['date_end'])<='01:00:00' ? "timer--finishing" : ""; ?>">
              <?= format_time($item["date_end"]);?>
            </div>
            <?php else : ?>
                <div class="lot__timer timer">Торги окончены</div>
            <?php endif; ?>
          </div>
        </div>
      </li>
    </ul> 
    <?php endforeach; ?>
  </section>