<?php
namespace App\Models;

use App\Core\Model;

class Journal extends Model
{
    public static function forDate(string $date): ?array
    {
        return self::one('SELECT * FROM journal WHERE entry_date = ? LIMIT 1', [$date]);
    }

    /** Inserta o actualiza (una entrada por día). */
    public static function save(string $date, string $title, string $content): void
    {
        if (self::forDate($date)) {
            self::run('UPDATE journal SET title = ?, content = ? WHERE entry_date = ?', [$title, $content, $date]);
        } else {
            self::run('INSERT INTO journal (title, content, entry_date) VALUES (?,?,?)', [$title, $content, $date]);
        }
    }

    public static function titlesForRange(string $from, string $to): array
    {
        $out = [];
        foreach (self::all('SELECT entry_date, title FROM journal WHERE entry_date BETWEEN ? AND ?', [$from, $to]) as $r) {
            $out[$r['entry_date']] = $r['title'];
        }
        return $out;
    }
}
