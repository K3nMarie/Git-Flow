<?php $cfg = \App\Core\Application::config(); ?>
<div class="page-head"><h2>Tareas</h2><a class="btn" href="/calendar">Ver en calendario</a></div>
<form method="post" action="/tasks" class="card inline">
  <?= \App\Core\Auth::field() ?>
  <label>Título <input name="title" maxlength="200" required></label>
  <label>Desc <input name="description" maxlength="500"></label>
  <label>Fecha <input type="date" name="due_date" value="<?= date('Y-m-d') ?>" required></label>
  <label>Tipo
    <select name="type"><?php foreach ($cfg['task_types'] as $t): ?><option><?= e($t) ?></option><?php endforeach; ?></select>
  </label>
  <button class="btn primary">Agregar</button>
</form>

<div class="card">
<table>
  <thead><tr><th>ID</th><th>Título</th><th>Descripción</th><th>Fecha</th><th>Status</th><th>Tipo</th><th></th></tr></thead>
  <tbody>
  <?php if (!$tasks): ?><tr><td colspan="7" class="muted">No hay tareas.</td></tr><?php endif; ?>
  <?php foreach ($tasks as $t): ?>
    <tr class="<?= $t['task_status'] === 'hecho' ? 'done' : '' ?>">
      <td><?= (int)$t['id'] ?></td>
      <td><?= e($t['task_name']) ?></td>
      <td><?= e($t['task_description']) ?></td>
      <td><?= e(date('d/m/Y', strtotime($t['due_date']))) ?></td>
      <td>
        <form method="post" action="/tasks/<?= (int)$t['id'] ?>/status" class="mini">
          <?= \App\Core\Auth::field() ?>
          <select name="status" onchange="this.form.submit()">
            <?php foreach ($cfg['task_statuses'] as $s): ?><option <?= $s === $t['task_status'] ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
          </select>
        </form>
      </td>
      <td><?= e($t['task_type']) ?></td>
      <td>
        <form method="post" action="/tasks/<?= (int)$t['id'] ?>/delete" class="mini" onsubmit="return confirm('¿Eliminar tarea?')">
          <?= \App\Core\Auth::field() ?><button class="btn danger">Eliminar</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
