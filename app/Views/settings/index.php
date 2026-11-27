<div class="page-head"><h2>Configuración</h2><p class="muted">Preferencias de MyMind</p></div>

<div class="grid-2">
  <div class="card">
    <h3>Apariencia</h3>
    <p class="muted">Elige el tema de la interfaz.</p>
    <div class="actions">
      <button class="btn" data-theme="auto">Automático</button>
      <button class="btn" data-theme="light">Claro</button>
      <button class="btn" data-theme="dark">Oscuro</button>
    </div>
  </div>

  <div class="card">
    <h3>Timer de estudio</h3>
    <dl class="kv">
      <dt>Bloque de estudio</dt><dd><?= intdiv($timer['study_block'], 60) ?> min</dd>
      <dt>Descanso</dt><dd><?= intdiv($timer['break'], 60) ?> min</dd>
      <dt>Zona horaria</dt><dd><?= e($tz) ?></dd>
    </dl>
    <p class="muted small">Se cambian en <code>config/config.php</code>.</p>
  </div>

  <div class="card">
    <h3>Tus datos</h3>
    <dl class="kv">
      <dt>Tareas</dt><dd><a href="/tasks"><?= $stats['tasks_total'] ?></a></dd>
      <dt>Entradas de journal</dt><dd><a href="/calendar"><?= $stats['journal_count'] ?></a></dd>
      <dt>Moods registrados</dt><dd><a href="/mood"><?= $stats['mood_count'] ?></a></dd>
      <dt>Sesiones de estudio</dt><dd><a href="/time"><?= $stats['sessions'] ?></a></dd>
    </dl>
  </div>

  <div class="card">
    <h3>Acerca de</h3>
    <p>MyMind — versión web sobre Git-Flow (PHP + SQLite).</p>
  </div>
</div>
