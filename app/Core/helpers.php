<?php
/** Escapa texto para HTML (usado en todas las vistas). */
function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

/**
 * Fecha legible en español. $long=false -> "26 nov 2026"; $long=true -> "Jueves 26 de noviembre de 2026".
 * Acepta 'Y-m-d' o 'Y-m-d H:i:s'.
 */
function fmt_date($d, bool $long = false): string
{
    $ts = strtotime((string)$d);
    if ($ts === false) return (string)$d;
    $months = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $days = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $m = $months[(int)date('n', $ts) - 1];
    $day = (int)date('j', $ts);
    $year = date('Y', $ts);
    if ($long) return $days[(int)date('w', $ts)] . " $day de $m de $year";
    return "$day " . mb_substr($m, 0, 3) . " $year";
}

/** Hora en formato 12 h: "2:03 p. m." (acepta 'H:i[:s]' o 'Y-m-d H:i:s'). */
function fmt_time($t): string
{
    $ts = strtotime((string)$t);
    if ($ts === false) return (string)$t;
    return (int)date('g', $ts) . ':' . date('i', $ts) . ' ' . (date('A', $ts) === 'AM' ? 'a. m.' : 'p. m.');
}

/** Duración legible: 4500 -> "1 h 15 min", 300 -> "5 min", 0 -> "0 min". */
function fmt_duration(int $seconds): string
{
    $m = intdiv($seconds + 30, 60); // redondea al minuto
    $h = intdiv($m, 60); $m %= 60;
    if ($h > 0) return $m > 0 ? "$h h $m min" : "$h h";
    return "$m min";
}
