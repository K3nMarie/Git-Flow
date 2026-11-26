<div class="page-head"><h2>Timer de estudio</h2><a class="btn" href="/time">Ver historial</a></div>
<div class="card timer" id="timer"
     data-state='<?= e(json_encode($state ?? ['idle' => true])) ?>'
     data-study="<?= (int)\App\Core\Application::config('timer')['study_block'] ?>"
     data-break="<?= (int)\App\Core\Application::config('timer')['break'] ?>">
  <svg viewBox="0 0 120 120" width="160" height="160">
    <circle cx="60" cy="60" r="50" fill="none" stroke="#dcdcdc" stroke-width="10"/>
    <circle id="ring" cx="60" cy="60" r="50" fill="none" stroke="#6496ff" stroke-width="10"
            stroke-linecap="round" stroke-dasharray="314.16" stroke-dashoffset="0" transform="rotate(-90 60 60)"/>
  </svg>
  <div id="total" class="time">Tiempo total: 0 min 00 s</div>
  <div id="partial" class="muted">Tiempo hasta próximo descanso: 0 min 00 s</div>
  <div id="msg" class="timer-msg"></div>
  <label>Horas de estudio: <input type="number" id="hours" min="1" max="12" value="1"></label>
  <div class="actions">
    <button class="btn primary" id="start">Iniciar</button>
    <button class="btn" id="stop" hidden>Detener</button>
  </div>
</div>
