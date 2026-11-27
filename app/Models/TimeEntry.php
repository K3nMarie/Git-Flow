<?php
namespace App\Models;

use App\Core\Model;

class TimeEntry extends Model
{
    public static function record(int $sessionId, int $study, int $break): void
    {
        self::run(
            'INSERT INTO time_entries (session_id, entry_date, study_seconds, break_seconds) VALUES (?,?,?,?)',
            [$sessionId, date('Y-m-d'), $study, $break]
        );
    }

    public static function recent(int $limit = 10): array
    {
        return self::all('SELECT * FROM time_entries ORDER BY id DESC LIMIT ' . (int)$limit);
    }

    public static function totals(): array
    {
        return self::one('SELECT COALESCE(SUM(study_seconds),0) AS study, COALESCE(SUM(break_seconds),0) AS brk, COUNT(*) AS sessions FROM time_entries')
            ?? ['study' => 0, 'brk' => 0, 'sessions' => 0];
    }
}
