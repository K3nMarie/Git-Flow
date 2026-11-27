<?php
namespace App\Models;

use App\Core\Model;

/** Eventos del calendario: entradas del journal + tareas con fecha límite. */
class Event extends Model
{
    /** @return array<string, array<int, array{type:string,label:string}>> indexado por fecha Y-m-d */
    public static function forRange(string $from, string $to): array
    {
        $events = [];
        foreach (Journal::titlesForRange($from, $to) as $date => $title) {
            $events[$date][] = ['type' => 'journal', 'label' => $title !== '' ? $title : '(sin título)'];
        }
        foreach (self::all('SELECT task_name, due_date FROM tasks WHERE due_date BETWEEN ? AND ? ORDER BY id', [$from, $to]) as $t) {
            $events[$t['due_date']][] = ['type' => 'task', 'label' => $t['task_name']];
        }
        return $events;
    }
}
