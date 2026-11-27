<?php
namespace App\Services;

use App\Core\Application;
use App\Models\TimeEntry;
use App\Models\TimerSession;

/**
 * Port de TimerController.java. En vez de un Timer de Swing que decrementa
 * cada segundo, el estado se calcula a partir del tiempo transcurrido, así
 * el temporizador sigue correcto aunque se recargue la página.
 */
class TimeTrackingService
{
    /** Ciclo: 30 min estudio + 5 min descanso, el total corre en tiempo real. */
    public static function stateAt(int $totalSeconds, int $elapsed): array
    {
        $study = Application::config('timer')['study_block'];
        $break = Application::config('timer')['break'];
        $cycle = $study + $break;

        $elapsed = max(0, $elapsed);
        $totalLeft = max(0, $totalSeconds - $elapsed);

        $pos = $elapsed % $cycle;
        $onBreak = $pos >= $study;
        $partial = $onBreak ? $cycle - $pos : $study - $pos;
        $partial = min($partial, $totalLeft); // el último bloque se recorta

        return [
            'total_left'   => $totalLeft,
            'partial_left' => $partial,
            'on_break'     => $onBreak && $totalLeft > 0,
            'finished'     => $totalLeft <= 0,
            'progress'     => $totalSeconds > 0 ? (int)round($totalLeft / $totalSeconds * 100) : 0,
        ];
    }

    public static function start(int $hours): int
    {
        return TimerSession::start($hours * 3600);
    }

    public static function currentState(): ?array
    {
        $s = TimerSession::running();
        if (!$s) return null;

        $elapsed = time() - (int)$s['started_at'];
        $state = self::stateAt((int)$s['total_seconds'], $elapsed);

        if ($state['finished']) {
            self::finish($s, (int)$s['total_seconds'], 'finished');
            $state['session_closed'] = true;
        }

        return $state + [
            'session_id'    => (int)$s['id'],
            'started_at'    => (int)$s['started_at'],
            'total_seconds' => (int)$s['total_seconds'],
            'server_now'    => time(),
        ];
    }

    public static function stop(): void
    {
        $s = TimerSession::running();
        if ($s) {
            self::finish($s, min(time() - (int)$s['started_at'], (int)$s['total_seconds']), 'stopped');
        }
    }

    /** Guarda el tiempo real de estudio/descanso en time_entries. */
    private static function finish(array $session, int $elapsed, string $status): void
    {
        $study = Application::config('timer')['study_block'];
        $break = Application::config('timer')['break'];
        $cycle = $study + $break;

        $fullCycles = intdiv($elapsed, $cycle);
        $rest = $elapsed % $cycle;
        $studySecs = $fullCycles * $study + min($rest, $study);
        $breakSecs = $fullCycles * $break + max(0, $rest - $study);

        TimerSession::close((int)$session['id'], $status);
        if ($elapsed > 0) {
            TimeEntry::record((int)$session['id'], $studySecs, $breakSecs);
        }
    }

    public static function fmt(int $seconds): string
    {
        return sprintf('%02d:%02d', intdiv($seconds, 60), $seconds % 60);
    }
}
