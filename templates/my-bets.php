<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
   <?php foreach ($user_bets as $key => $item): ?>
    <tr class="rates__item <?php if ($user_id === $item['winner_id']) { echo 'rates__item--win'; }
            elseif (!($user_id === $item['winner_id']) && ($item['winner_id'])) {echo 'rates__item--end';} ?>">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $item['image']; ?>" width="54" height="40" alt="<?= $item['image']; ?>">
        </div>
        <div>
            <h3 class="rates__title"><a href="lot.php?id=<?= $item['lot_id']; ?>"><?= htmlspecialchars($item['name']); ?></a></h3>
            <p><?php if ($user_id === $item['winner_id']){ echo htmlspecialchars($item['contact']);} ?></p>
        </div>
      </td>
      <td class="rates__category">
        <?= htmlspecialchars($item['category']); ?> 
      </td>
      <td class="rates__timer">
       <?php if (strtotime($item['date_end']) > time()) : ?>
        <div class="timer <?=format_time($item['date_end'])<='01:00:00' ? "timer--finishing" : ""; ?>">
            <?= format_time($item['date_end']); ?>
        </div>
        <?php else : ?>
            <div class="timer timer--end">Торги окончены</div>
        <?php endif; ?>
      </td>
      <td class="rates__price">
        <?= htmlspecialchars(format_cost($item['bet_price'])); ?>
      </td>
      <td class="rates__time">
        <?= htmlspecialchars(time_bets($item['date_create'])); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</section>