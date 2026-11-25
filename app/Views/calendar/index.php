<?php $names = \App\Core\Application::config('days'); $today = date('Y-m-d'); ?>
<div class="page-head"><h2>Calendario</h2><a class="btn primary" href="/journal">Journal de hoy</a></div>
<div class="card">
  <div class="week-head">
    <a class="btn" href="/calendar?m=<?= $prev['m'] ?>&y=<?= $prev['y'] ?>">‹</a>
    <span class="nav-btns"><a class="btn" href="/calendar">Hoy</a></span>
    <strong class="big"><?= e($heading) ?></strong>
    <a class="btn" href="/calendar?m=<?= $next['m'] ?>&y=<?= $next['y'] ?>">›</a>
  </div>
  <div class="grid7 month">
    <?php foreach ($names as $n): ?><div class="dow"><?= $n ?></div><?php endforeach; ?>
    <?php for ($i = 0; $i < $lead; $i++): ?><div class="day empty"></div><?php endfor; ?>
    <?php for ($d = 1; $d <= $daysInMonth; $d++):
        $date = sprintf('%04d-%02d-%02d', $year, $month, $d);
        $dow = ($lead + $d - 1) % 7;
        $cls = $date === $today ? 'today' : (($dow === 0 || $dow === 6) ? 'weekend' : ''); ?>
      <a class="day <?= $cls ?>" href="/journal/<?= $date ?>">
        <span class="num"><?= $d ?></span>
        <?php foreach (array_slice($events[$date] ?? [], 0, 3) as $ev): ?>
          <small class="ev <?= e($ev['type']) ?>"><?= e($ev['label']) ?></small>
        <?php endforeach; ?>
      </a>
    <?php endfor; ?>
  </div>
  <p class="muted">Haz clic en un día para abrir su journal. <span class="legend journal">■</span> journal <span class="legend task">■</span> tarea</p>
</div>
