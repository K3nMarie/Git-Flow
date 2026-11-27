<?php
namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Models\TimeEntry;
use App\Services\TimeTrackingService;

/** Reemplaza las interfaces GetDate / GetTime y muestra el historial de estudio. */
class TimeManagementController extends Controller
{
    public function index(): void
    {
        $this->render('time/index', [
            'entries' => TimeEntry::recent(20),
            'totals' => TimeEntry::totals(),
        ], 'Historial');
    }

    /** Fecha y hora actuales del servidor (reloj de la barra superior). */
    public function now(): void
    {
        $n = new \DateTime();
        $this->json([
            'day' => (int)$n->format('j'),
            'month' => (int)$n->format('n'),
            'year' => (int)$n->format('Y'),
            'full_date' => $n->format('d/m/Y'),
            'hour' => (int)$n->format('G'),
            'minute' => (int)$n->format('i'),
            'second' => (int)$n->format('s'),
            'time' => fmt_time($n->format('H:i:s')),
        ]);
    }
}
