<?php
namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Services\StatisticsService;

/** Pantalla "Configuración" del menú original de MyMind. */
class SettingsController extends Controller
{
    public function index(): void
    {
        $this->render('settings/index', [
            'timer' => Application::config('timer'),
            'tz' => Application::config('timezone'),
            'stats' => StatisticsService::summary(),
        ], 'Configuración');
    }
}
