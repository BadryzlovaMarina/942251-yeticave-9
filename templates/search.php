<section class="lots">
    <?php if ($search) : ?>
        <h2>Результаты поиска по запросу «<span><?=$search; ?></span>»</h2>
    <?php else : ?>
          <h2>Результаты поиска по запросу «<span>Ничего не найдено по вашему запросу</span>»</h2>
    <?php endif; ?>
    <ul class="lots__list">
     <?php foreach ($lots as $key => $item):?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $item["image"];?>" width="350" height="260" alt="<?= $item["name"];?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $item["category"];?></span>
          <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $item['id']; ?>"><?= $item["name"];?></a></h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= format_cost($item["start_price"]);?><b class="rub">р</b></span>
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
      <?php endforeach; ?>
    </ul>
</section>
<?php if ($pages_count > 1):?>
  <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a href="search.php?search=<?= $search; ?>&page=<?php if ($cur_page > 1) { echo($cur_page - 1);} else { echo $cur_page;} ?>">Назад</a></li>
    <?php foreach ($pages as $page):?>
    <li class="pagination-item <?php if ($page == $cur_page):?>pagination-item-active<?php endif;?>"><a href="search.php?search=<?= $search;?>&page=<?= $page;?>"><?= $page;?></a></li>
    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next"><a href="search.php?search=<?= $search;?>&page=<?php if ($cur_page < $pages_count) { echo($cur_page + 1);} else { echo $cur_page;}?>">Вперед</a></li>
  </ul>
<?php endif;?>