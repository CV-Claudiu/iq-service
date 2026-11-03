<?php
// Exemplul 19 - un mesaj ales după cuvântul din adresă
// Încearcă: 19_mesaje.php?stare=adaugat, apoi stare=sters, apoi stare=altceva
 
$mesaje = [
    'adaugat' => 'Am adăugat o persoană.',
    'sters'   => 'Am șters o persoană.',
];
 
$stare = $_GET['stare'] ?? '';
 
$mesaj = $mesaje[$stare] ?? 'Niciun mesaj.';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 19 - mesaje</title>
</head>
<body>
    <p><?php echo $mesaj; ?></p>
 
    <p>
        <a href="19_mesaje.php?stare=adaugat">adaugat</a> |
        <a href="19_mesaje.php?stare=sters">sters</a> |
        <a href="19_mesaje.php?stare=altceva">altceva</a>
    </p>
</body>
</html>