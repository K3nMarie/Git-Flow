<?php use App\Services\TimeTrackingService as T; ?>
<div class="page-head"><h2>Historial de estudio</h2><a class="btn primary" href="/timer">Nueva sesión</a></div>
<div class="card">
  <p><strong><?= $totals['sessions'] ?></strong> sesiones · <strong><?= round($totals['study'] / 3600, 2) ?> h</strong> de estudio · <strong><?= round($totals['brk'] / 60) ?> min</strong> de descanso</p>
  <table>
    <thead><tr><th>Fecha</th><th>Estudio</th><th>Descanso</th></tr></thead>
    <tbody>
    <?php if (!$entries): ?><tr><td colspan="3" class="muted">Aún no hay sesiones.</td></tr><?php endif; ?>
    <?php foreach ($entries as $en): ?>
      <tr><td><?= e(date('d/m/Y', strtotime($en['entry_date']))) ?></td><td><?= fmt_duration((int)$en['study_seconds']) ?></td><td><?= fmt_duration((int)$en['break_seconds']) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
