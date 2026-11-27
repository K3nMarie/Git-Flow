<?php
namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Models\Event;

/** Calendario mensual (CalendarFunc.java / CalendarGUI.java). */
class CalendarController extends Controller
{
    public function index(): void
    {
        $month = max(1, min(12, (int)($_GET['m'] ?? date('n'))));
        $year  = max(1970, min(2200, (int)($_GET['y'] ?? date('Y'))));

        $first = new \DateTime(sprintf('%04d-%02d-01', $year, $month));
        $daysInMonth = (int)$first->format('t');
        $lead = (int)$first->format('w');

        $events = Event::forRange($first->format('Y-m-01'), $first->format('Y-m-') . $daysInMonth);

        $prev = (clone $first)->modify('-1 month');
        $next = (clone $first)->modify('+1 month');

        $this->render('calendar/index', [
            'heading' => Application::config('months')[$month - 1] . ' ' . $year,
            'lead' => $lead,
            'daysInMonth' => $daysInMonth,
            'year' => $year,
            'month' => $month,
            'events' => $events,
            'prev' => ['m' => (int)$prev->format('n'), 'y' => (int)$prev->format('Y')],
            'next' => ['m' => (int)$next->format('n'), 'y' => (int)$next->format('Y')],
        ], 'Calendario');
    }
}
