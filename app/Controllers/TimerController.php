<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\TimeTrackingService;

class TimerController extends Controller
{
    public function index(): void
    {
        $this->render('timer/index', ['state' => TimeTrackingService::currentState()], 'Timer');
    }

    public function state(): void
    {
        $this->json(TimeTrackingService::currentState() ?? ['idle' => true]);
    }

    public function start(): void
    {
        $hours = (int)($_POST['hours'] ?? 1);
        if ($hours < 1 || $hours > 12) {
            $this->json(['error' => 'Horas inválidas (1-12)'], 422);
        }
        TimeTrackingService::start($hours);
        $this->json(TimeTrackingService::currentState());
    }

    public function stop(): void
    {
        TimeTrackingService::stop();
        $this->json(['idle' => true]);
    }
}
