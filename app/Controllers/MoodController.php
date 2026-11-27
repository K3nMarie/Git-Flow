<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Mood;

class MoodController extends Controller
{
    public function index(): void
    {
        $this->render('mood/index', ['days' => Mood::groupedByDay()], 'Moodtracker');
    }

    public function store(): void
    {
        preg_match('/^.{0,100}/us', $this->input('mood'), $m); // máx. 100 caracteres (UTF-8 seguro)
        $mood = $m[0] ?? '';
        if ($mood !== '') Mood::log($mood); // evita strings vacíos
        $this->redirect('/mood');
    }
}
