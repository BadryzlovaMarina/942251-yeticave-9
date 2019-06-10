<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
   <?php foreach ($user_bets as $key => $item): ?>
    <tr class="rates__item ">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $item["image"]; ?>" width="54" height="40" alt="<?= $item["image"]; ?>">
        </div>
        <h3 class="rates__title"><a href="lot.php?id=<?= $item["lot_id"]; ?>"><?= htmlspecialchars($item["name"]); ?></a></h3>
      </td>
      <td class="rates__category">
        <?= htmlspecialchars($item["category"]); ?> 
      </td>
      <td class="rates__timer">
        <div class="timer <?=format_time($item["date_end"])<='01:00:00' ? "timer--finishing" : ""; ?>">
            <?= format_time($item["date_end"]); ?>
        </div>
      </td>
      <td class="rates__price">
        <?= htmlspecialchars(format_cost($item["bet_price"])); ?>
      </td>
      <td class="rates__time">
        <?= htmlspecialchars(time_bets($item["date_create"])); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</section>