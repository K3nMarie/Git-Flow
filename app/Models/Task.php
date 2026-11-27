<?php
namespace App\Models;

use App\Core\Model;

/** Port de TaskListAbstract / FluidTask / RepeatingTask + consultas de DatabaseManager. */
class Task extends Model
{
    public static function allTasks(): array
    {
        return self::all('SELECT * FROM tasks ORDER BY due_date ASC, id ASC');
    }

    public static function create(string $name, string $desc, string $type, string $due): void
    {
        self::run(
            'INSERT INTO tasks (task_name, task_description, task_status, task_type, due_date) VALUES (?,?,?,?,?)',
            [$name, $desc, 'sin hacer', $type, $due]
        );
    }

    public static function setStatus(int $id, string $status): void
    {
        self::run('UPDATE tasks SET task_status = ? WHERE id = ?', [$status, $id]);
    }

    public static function delete(int $id): void
    {
        self::run('DELETE FROM tasks WHERE id = ?', [$id]);
    }

    public static function dueOn(string $date): array
    {
        return self::all('SELECT * FROM tasks WHERE due_date = ?', [$date]);
    }

    /** Equivalente a getDetails() de las clases Java. */
    public static function details(array $t): string
    {
        $prefix = $t['task_type'] === 'Repetitiva' ? '[Repetitiva] ' : '[Fluida] ';
        return $prefix . $t['task_name'] . ' (' . $t['task_status'] . ')';
    }
}
