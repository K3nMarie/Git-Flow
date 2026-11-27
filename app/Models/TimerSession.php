<?php
namespace App\Models;

use App\Core\Model;

class TimerSession extends Model
{
    public static function start(int $totalSeconds): int
    {
        self::run("UPDATE timer_sessions SET status = 'stopped' WHERE status = 'running'");
        self::run('INSERT INTO timer_sessions (started_at, total_seconds, status) VALUES (?,?,?)', [time(), $totalSeconds, 'running']);
        return (int)self::db()->lastInsertId();
    }

    public static function running(): ?array
    {
        return self::one("SELECT * FROM timer_sessions WHERE status = 'running' ORDER BY id DESC LIMIT 1");
    }

    public static function close(int $id, string $status): void
    {
        self::run('UPDATE timer_sessions SET status = ? WHERE id = ?', [$status, $id]);
    }
}
