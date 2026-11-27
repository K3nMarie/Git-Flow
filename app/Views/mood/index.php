<div class="page-head"><h2>Moodtracker</h2></div>
<form method="post" action="/mood" class="card inline">
  <?= \App\Core\Auth::field() ?>
  <label>Mood: <input type="text" name="mood" id="mood-input" maxlength="100" required autofocus></label>
  <button class="btn primary">Guardar mood</button>
  <span class="quick">
    <?php foreach (['Feliz', 'Triste', 'Enojado'] as $label): ?>
      <button type="button" class="btn" title="<?= $label ?>" data-mood="<?= $label ?>"><?= $label ?></button>
    <?php endforeach; ?>
  </span>
</form>

<?php if (!$days): ?><p class="muted">Aún no hay moods registrados.</p><?php endif; ?>
<?php foreach ($days as $date => $moods): ?>
  <div class="card">
    <strong><?= e($date) ?></strong>
    <ul>
      <?php foreach ($moods as $m): ?>
        <li><?= e(fmt_time($m['mood_time'])) ?> · <?= e($m['mood']) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endforeach; ?>
<script>
document.querySelectorAll('[data-mood]').forEach(b => b.addEventListener('click', () => {
  document.getElementById('mood-input').value = b.dataset.mood;
  document.getElementById('mood-input').focus();
}));
</script>
