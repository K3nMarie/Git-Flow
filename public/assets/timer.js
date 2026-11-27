// Temporizador: 30 min estudio / 5 min descanso (port de TimerController + TimerGUI).
(function () {
  const root = document.getElementById('timer');
  const csrf = document.querySelector('meta[name=csrf]').content;
  const STUDY = +root.dataset.study, BREAK = +root.dataset.break, CYCLE = STUDY + BREAK;
  const $ = id => document.getElementById(id);
  const fmt = s => {
    const h = Math.floor(s / 3600), m = Math.floor(s % 3600 / 60), sec = s % 60, p = n => String(n).padStart(2, '0');
    return h > 0 ? `${h} h ${p(m)} min ${p(sec)} s` : `${m} min ${p(sec)} s`;
  };
  const CIRC = 314.16;

  let session = null, offset = 0, lastBreak = false, loop = null;

  function compute(total, elapsed) {
    elapsed = Math.max(0, elapsed);
    const totalLeft = Math.max(0, total - elapsed);
    const pos = elapsed % CYCLE, onBreak = pos >= STUDY;
    const partial = Math.min(onBreak ? CYCLE - pos : STUDY - pos, totalLeft);
    return { totalLeft, partial, onBreak: onBreak && totalLeft > 0, finished: totalLeft <= 0 };
  }

  function render() {
    const s = compute(session.total_seconds, Math.floor(Date.now() / 1000) + offset - session.started_at);
    $('total').textContent = 'Tiempo total: ' + fmt(s.totalLeft);
    $('partial').textContent = (s.onBreak ? 'Tiempo hasta fin de descanso: ' : 'Tiempo hasta próximo descanso: ') + fmt(s.partial);
    $('ring').style.strokeDashoffset = CIRC * (1 - s.totalLeft / session.total_seconds);

    if (s.onBreak && !lastBreak) $('msg').textContent = 'Descansa 5 minutos';
    if (!s.onBreak && lastBreak && !s.finished) $('msg').textContent = 'Vuelve a estudiar';
    lastBreak = s.onBreak;

    if (s.finished) { stopLoop(); $('msg').textContent = 'Has terminado tu tiempo de estudio'; setIdle(true); fetch('/timer/state'); }
  }

  function setIdle(idle) { $('start').hidden = !idle; $('stop').hidden = idle; $('hours').disabled = !idle; }
  function stopLoop() { clearInterval(loop); loop = null; }

  function run(state) {
    session = state; offset = state.server_now - Math.floor(Date.now() / 1000);
    lastBreak = false; setIdle(false); render();
    stopLoop(); loop = setInterval(render, 1000);
  }

  function post(url, body) {
    return fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-Token': csrf }, body: new URLSearchParams(body) }).then(r => r.json());
  }

  $('start').addEventListener('click', async () => {
    const res = await post('/timer/start', { hours: $('hours').value });
    if (res.error) { $('msg').textContent = res.error; return; }
    $('msg').textContent = ''; run(res);
  });
  $('stop').addEventListener('click', async () => {
    await post('/timer/stop', {}); stopLoop(); setIdle(true);
    $('total').textContent = 'Tiempo total: 0 min 00 s'; $('ring').style.strokeDashoffset = 0; $('msg').textContent = 'Sesión detenida';
  });

  const initial = JSON.parse(root.dataset.state);
  if (initial && !initial.idle && !initial.finished) run(initial); else setIdle(true);
})();
