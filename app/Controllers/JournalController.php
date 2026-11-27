<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Journal;

class JournalController extends Controller
{
    public function today(): void
    {
        $this->redirect('/journal/' . date('Y-m-d'));
    }

    public function edit(string $date): void
    {
        if (!$this->validDate($date)) $this->redirect('/calendar');
        $this->render('journal/edit', ['date' => $date, 'entry' => Journal::forDate($date)], 'Journal');
    }

    public function save(string $date): void
    {
        if (!$this->validDate($date)) $this->redirect('/calendar');
        Journal::save($date, $this->input('title'), trim((string)($_POST['content'] ?? '')));
        Auth::flash('Guardado');
        $this->redirect('/calendar?y=' . substr($date, 0, 4) . '&m=' . (int)substr($date, 5, 2));
    }
}
