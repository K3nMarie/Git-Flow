<?php $names = \App\Core\Application::config('days'); ?>
<div class="page-head"><h2>Esta semana</h2><p class="muted"><?= e(fmt_date(date('Y-m-d'), true)) ?></p></div>

<div class="quick">
  <a class="card q" href="/journal"><b>Escribir hoy</b><small>Abrir el journal de hoy</small></a>
  <a class="card q" href="/tasks"><b>Tareas</b><small><?= $stats['tasks_pending'] ?> pendientes</small></a>
  <a class="card q" href="/mood"><b>¿Cómo te sientes?</b><small>Registrar mood</small></a>
  <a class="card q" href="/timer"><b>Estudiar</b><small>Iniciar timer</small></a>
</div>

<div class="card week">
  <div class="week-head">
    <a class="btn" href="/?w=<?= $offset - 1 ?>" aria-label="Semana anterior">‹</a>
    <strong class="big"><?= e($weekLabel) ?></strong>
    <?php if ($offset != 0): ?><a class="btn" href="/">Hoy</a><?php endif; ?><a class="btn" href="/?w=<?= $offset + 1 ?>" aria-label="Semana siguiente">›</a>
  </div>
  <div class="grid7">
    <?php foreach ($names as $n): ?><div class="dow"><?= $n ?></div><?php endforeach; ?>
    <?php foreach ($days as $d): ?>
      <a class="day <?= $d['today'] ? 'today' : '' ?>" href="/journal/<?= e($d['date']) ?>">
        <span class="num"><?= $d['day'] ?></span>
        <?php foreach (array_slice($d['events'], 0, 3) as $ev): ?>
          <small class="ev <?= e($ev['type']) ?>"><?= e($ev['label']) ?></small>
        <?php endforeach; ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<h3 class="section">Resumen</h3>
<div class="stats">
  <div class="card stat"><b><?= $stats['tasks_pending'] ?></b><span>tareas pendientes</span></div>
  <div class="card stat"><b><?= $stats['tasks_done'] ?></b><span>tareas hechas</span></div>
  <div class="card stat"><b><?= $stats['journal_count'] ?></b><span>entradas de journal</span></div>
  <div class="card stat"><b><?= e($stats['top_mood'] ?? '—') ?></b><span>mood más frecuente</span></div>
  <div class="card stat"><b><?= round($stats['study_seconds'] / 3600, 1) ?> h</b><span>estudiadas (<?= $stats['sessions'] ?> sesiones)</span></div>
</div>
