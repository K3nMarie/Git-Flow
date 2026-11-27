<?php use App\Core\Auth;
$nav = [
  ['/', 'Inicio', 'dashboard'],
  ['/calendar', 'Calendario', 'calendar'],
  ['/tasks', 'Tareas', 'tasks'],
  ['/journal', 'Journal', 'journal'],
  ['/mood', 'Moodtracker', 'mood'],
  ['/timer', 'Timer', 'timer'],
  ['/time', 'Historial', 'time'],
  ['/settings', 'Configuración', 'settings'],
]; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf" content="<?= e(Auth::token()) ?>">
<title><?= e($title) ?> · MyMind</title>
<script>document.documentElement.dataset.theme = localStorage.getItem('theme') || 'auto';</script>
<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header class="topbar">
  <button id="toggle-sidebar" class="icon-only" aria-label="Menú">☰</button>
  <a class="brand" href="/">MyMind</a>
  <span class="page-title"><?= e($title) ?></span>
  <span id="clock" title="Hora actual">--:--:--</span>
</header>
<div class="shell">
  <nav class="sidebar" id="sidebar" aria-label="Navegación principal">
    <?php foreach ($nav as [$href, $label, $key]): ?>
      <a href="<?= $href ?>" class="<?= $active === $key ? 'active' : '' ?>" <?= $active === $key ? 'aria-current="page"' : '' ?>>
        <?= $label ?>
      </a>
    <?php endforeach; ?>
  </nav>
  <div class="scrim" id="scrim"></div>
  <main>
    <?php if ($flash): ?><div class="flash" role="status"><?= e($flash) ?></div><?php endif; ?>
    <?= $content ?>
  </main>
</div>
<script src="/assets/app.js"></script>
<?php if ($active === 'timer'): ?><script src="/assets/timer.js"></script><?php endif; ?>
</body>
</html>
