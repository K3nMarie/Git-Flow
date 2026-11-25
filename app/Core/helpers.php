<?php
/** Escapa texto para HTML (usado en todas las vistas). */
function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
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
