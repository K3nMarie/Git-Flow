<?php
use App\Core\Router;

return function (Router $r) {
    $r->get('/', 'DashboardController@index');

    $r->get('/calendar', 'CalendarController@index');

    $r->get('/journal', 'JournalController@today');
    $r->get('/journal/{date}', 'JournalController@edit');
    $r->post('/journal/{date}', 'JournalController@save');

    $r->get('/mood', 'MoodController@index');
    $r->post('/mood', 'MoodController@store');

    $r->get('/tasks', 'TaskController@index');
    $r->post('/tasks', 'TaskController@store');
    $r->post('/tasks/{id}/status', 'TaskController@status');
    $r->post('/tasks/{id}/delete', 'TaskController@delete');

    $r->get('/timer', 'TimerController@index');
    $r->get('/timer/state', 'TimerController@state');
    $r->post('/timer/start', 'TimerController@start');
    $r->post('/timer/stop', 'TimerController@stop');

    $r->get('/time', 'TimeManagementController@index');
    $r->get('/time/now', 'TimeManagementController@now');

    $r->get('/settings', 'SettingsController@index');
};
