<?php
namespace App\Services;

use App\Core\Database;
use App\Models\TimeEntry;

class StatisticsService
{
    public static function summary(): array
    {
        $db = Database::connection();
        $tasks = $db->query('SELECT task_status, COUNT(*) c FROM tasks GROUP BY task_status')->fetchAll(\PDO::FETCH_KEY_PAIR);
        $topMood = $db->query('SELECT mood, COUNT(*) c FROM moodtracker GROUP BY mood ORDER BY c DESC LIMIT 1')->fetch();
        $moodCount = (int)$db->query('SELECT COUNT(*) FROM moodtracker')->fetchColumn();
        $journalCount = (int)$db->query('SELECT COUNT(*) FROM journal')->fetchColumn();
        $time = TimeEntry::totals();

        return [
            'tasks_total'   => array_sum($tasks),
            'tasks_pending' => (int)($tasks['sin hacer'] ?? 0) + (int)($tasks['en progreso'] ?? 0),
            'tasks_done'    => (int)($tasks['hecho'] ?? 0),
            'mood_count'    => $moodCount,
            'top_mood'      => $topMood['mood'] ?? null,
            'journal_count' => $journalCount,
            'study_seconds' => (int)$time['study'],
            'sessions'      => (int)$time['sessions'],
        ];
    }
}
