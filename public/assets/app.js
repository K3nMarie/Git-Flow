// Reloj de la barra superior (portado de MainWindowGUI.startClock) + sidebar toggle
(function () {
  const clock = document.getElementById('clock');
  const pad = n => String(n).padStart(2, '0');
  // Hora del servidor (/time/now) para que coincida con la zona horaria de config.php;
  // mientras no responda se muestra la hora del navegador.
  let server = null; // { secs: segundos del día en el servidor, at: Date.now() al recibirlos }
  function sync() {
    fetch('/time/now').then(r => r.json()).then(t => {
      server = { secs: t.hour * 3600 + t.minute * 60 + t.second, at: Date.now() };
      tick();
    }).catch(() => {});
  }
  function tick() {
    let h, m, s;
    if (server) {
      const secs = (server.secs + Math.floor((Date.now() - server.at) / 1000)) % 86400;
      h = Math.floor(secs / 3600); m = Math.floor(secs % 3600 / 60); s = secs % 60;
    } else {
      const d = new Date(); h = d.getHours(); m = d.getMinutes(); s = d.getSeconds();
    }
    clock.textContent = `${h % 12 || 12}:${pad(m)}:${pad(s)} ${h < 12 ? 'a. m.' : 'p. m.'}`;
  }
  tick(); setInterval(tick, 1000);
  sync(); setInterval(sync, 5 * 60 * 1000);

  const sb = document.getElementById('sidebar');
  if (localStorage.getItem('sidebar') === 'hidden') sb.classList.add('hidden');
  document.getElementById('toggle-sidebar').addEventListener('click', () => {
    if (window.matchMedia('(max-width: 800px)').matches) { sb.classList.toggle('open'); return; }
    sb.classList.toggle('hidden');
    localStorage.setItem('sidebar', sb.classList.contains('hidden') ? 'hidden' : 'shown');
  });
})();

// Tema, menú móvil y botones de tema
(function () {
  const root = document.documentElement;
  // Solo los botones: <html> también tiene data-theme y no debe recibir estos eventos.
  document.querySelectorAll('button[data-theme]').forEach(b => b.addEventListener('click', () => {
    localStorage.setItem('theme', b.dataset.theme); root.dataset.theme = b.dataset.theme;
    document.querySelectorAll('button[data-theme]').forEach(x => x.classList.toggle('primary', x === b));
  }));
  const cur = localStorage.getItem('theme') || 'auto';
  document.querySelectorAll('button[data-theme]').forEach(x => x.classList.toggle('primary', x.dataset.theme === cur));

  const scrim = document.getElementById('scrim'), sb = document.getElementById('sidebar');
  scrim.addEventListener('click', () => sb.classList.remove('open'));
  sb.querySelectorAll('a').forEach(a => a.addEventListener('click', () => sb.classList.remove('open')));
})();
