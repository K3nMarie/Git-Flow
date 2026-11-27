<?php
namespace App\Controllers;

use App\Core\Application;
use App\Core\Auth;
use App\Core\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(): void
    {
        $this->render('tasks/index', ['tasks' => Task::allTasks()], 'Tareas');
    }

    public function store(): void
    {
        $name = $this->input('title');
        $due  = $this->input('due_date');
        $type = $this->input('type', 'Fluida');

        if ($name === '' || !$this->validDate($due) || !in_array($type, Application::config('task_types'), true)) {
            Auth::flash('Datos inválidos: revisa el título y la fecha.');
            $this->redirect('/tasks');
        }
        Task::create($name, $this->input('description'), $type, $due);
        $this->redirect('/tasks');
    }

    public function status(string $id): void
    {
        $status = $this->input('status');
        if (in_array($status, Application::config('task_statuses'), true)) {
            Task::setStatus((int)$id, $status);
        }
        $this->redirect('/tasks');
    }

    public function delete(string $id): void
    {
        Task::delete((int)$id);
        $this->redirect('/tasks');
    }
}
