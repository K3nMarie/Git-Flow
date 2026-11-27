<?php $prev = date('Y-m-d', strtotime("$date -1 day")); $next = date('Y-m-d', strtotime("$date +1 day")); ?>
<div class="page-head"><h2>Journal — <?= e(fmt_date($date, true)) ?></h2>
  <div class="actions"><a class="btn" href="/journal/<?= $prev ?>">‹ Día anterior</a><a class="btn" href="/journal/<?= $next ?>">Día siguiente ›</a></div></div>
<form method="post" action="/journal/<?= e($date) ?>" class="card form-col">
  <?= \App\Core\Auth::field() ?>
  <label>Título
    <input type="text" name="title" maxlength="200" value="<?= e($entry['title'] ?? '') ?>">
  </label>
  <label>Contenido
    <textarea name="content" rows="16"><?= e($entry['content'] ?? '') ?></textarea>
  </label>
  <div class="actions">
    <button class="btn primary">Guardar</button>
    <a class="btn" href="/calendar?y=<?= e(substr($date,0,4)) ?>&m=<?= (int)substr($date,5,2) ?>">Volver al calendario</a>
  </div>
</form>
