<?php
// Configuración central de MyMind (versión web / Gitflow)
return [
    'app_name' => 'MyMind',
    'timezone' => 'America/Santo_Domingo',
    'db_path'  => __DIR__ . '/../database/app.sqlite',

    // Temporizador de estudio (portado de TimerController.java)
    'timer' => [
        'study_block' => 30 * 60, // bloque de estudio: 30 min
        'break'       => 5 * 60,  // descanso: 5 min
    ],

    'months' => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    'days'   => ['D','L','M','M','J','V','S'],
    'task_types'    => ['Fluida', 'Repetitiva'],
    'task_statuses' => ['sin hacer', 'en progreso', 'hecho'],
];
