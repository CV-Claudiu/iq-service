<?php
// IQ SERVICE - listele fixe ale aplicației (Ziua 17)
// Valorile coloanelor ENUM din tabelul solicitari, cu textul și culoarea lor pe ecran.
 
 
$prioritati = [
    'mica'    => 'Mică',
    'normala' => 'Normală',
    'urgenta' => 'Urgentă',
];
 
$culoriPrioritate = [
    'mica'    => 'secondary',
    'normala' => 'primary',
    'urgenta' => 'danger',
];
 
$statusuri = [
    'noua'      => 'Nouă',
    'in_lucru'  => 'În lucru',
    'rezolvata' => 'Rezolvată',
    'inchisa'   => 'Închisă',
];
 
$culoriStatus = [
    'noua'      => 'info',
    'in_lucru'  => 'warning',
    'rezolvata' => 'success',
    'inchisa'   => 'dark',
];

$tipuriActivitate = [
    'telefon'     => 'Telefon',
    'vizita'      => 'Vizită',
    'email'       => 'E-mail',
    'interventie' => 'Intervenție',
    'alta'        => 'Altă activitate',
];
 
function durata($minute)
{
    if ($minute === null) {
        return '';
    }
    $ore  = intdiv($minute, 60);
    $rest = $minute % 60;
 
    if ($ore === 0) {
        return $rest . ' min';
    }
    if ($rest === 0) {
        return $ore . ' h';
    }
    return $ore . ' h ' . $rest . ' min';
}
