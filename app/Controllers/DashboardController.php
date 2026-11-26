<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;
use App\Services\StatisticsService;

/** Vista inicial: calendario semanal (MainCalendar.java) + resumen. */
class DashboardController extends Controller
{
    public function index(): void
    {
        $offset = (int)($_GET['w'] ?? 0);
        $start = new \DateTime('today');
        $start->modify(($offset >= 0 ? '+' : '') . $offset . ' week');
        $start->modify('-' . $start->format('w') . ' days'); // domingo como base

        $end = (clone $start)->modify('+6 days');
        $events = Event::forRange($start->format('Y-m-d'), $end->format('Y-m-d'));

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $d = (clone $start)->modify("+$i days");
            $key = $d->format('Y-m-d');
            $days[] = ['date' => $key, 'day' => (int)$d->format('j'), 'today' => $key === date('Y-m-d'), 'events' => $events[$key] ?? []];
        }

        $weekOfMonth = (int)ceil(((int)$start->format('j') + (int)(new \DateTime($start->format('Y-m-01')))->format('w')) / 7);

        $this->render('dashboard/index', [
            'days' => $days,
            'offset' => $offset,
            'weekLabel' => 'Semana ' . $weekOfMonth . ' - ' . \App\Core\Application::config('months')[(int)$start->format('n') - 1] . ' ' . $start->format('Y'),
            'stats' => StatisticsService::summary(),
        ], 'Inicio');
    }
}
