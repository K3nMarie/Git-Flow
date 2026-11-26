<?php
namespace App\Models;

use App\Core\Model;

class Mood extends Model
{
    public static function log(string $mood): void
    {
        self::run('INSERT INTO moodtracker (mood_time, mood) VALUES (?, ?)', [date('Y-m-d H:i:s'), $mood]);
    }

    /** Moods agrupados por día, más recientes primero (igual que MoodTrackerGUI.refreshCards). */
    public static function groupedByDay(): array
    {
        $rows = self::all('SELECT id, mood, mood_time FROM moodtracker ORDER BY mood_time DESC, id DESC');
        $days = [];
        foreach ($rows as $r) {
            $days[substr($r['mood_time'], 0, 10)][] = $r;
        }
        return $days;
    }
}
