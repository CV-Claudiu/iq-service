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
