<?php
// IQ SERVICE - citirea configurației din fișierul .env
//
// Parser didactic, simplificat:
//  - o pereche CHEIE=valoare pe fiecare linie;
//  - liniile goale și cele care încep cu # sunt ignorate;
//  - NU tratează ghilimele, comentarii la finalul liniei sau valori pe mai multe linii.
// În proiectele mari se folosește o bibliotecă dedicată (vlucas/phpdotenv).
 
function loadEnv(string $cale): array
{
    if (!is_file($cale)) {
        throw new RuntimeException('Lipsește fișierul de configurare: ' . $cale);
    }
 
    $config = [];
    $linii  = file($cale, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 
    foreach ($linii as $linie) {
        $linie = trim($linie);
 
        if ($linie === '' || str_starts_with($linie, '#')) {
            continue;
        }
 
        if (!str_contains($linie, '=')) {
            continue;
        }
 
        [$cheie, $valoare] = explode('=', $linie, 2);
        $config[trim($cheie)] = trim($valoare);
    }
 
    return $config;
}
