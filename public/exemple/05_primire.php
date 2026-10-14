<?php
// Exemplul 5 - pagina care primește datele din formular
 
$denumire = $_POST['denumire'] ?? '';
$oras     = $_POST['oras'] ?? '';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 5 - date primite</title>
</head>
<body>
    <h1>Am primit:</h1>
    <p>Denumire: <?php echo htmlspecialchars($denumire); ?></p>
    <p>Oraș: <?php echo htmlspecialchars($oras); ?></p>
 
    <a href="04_formular.html">Înapoi la formular</a>
</body>
</html>
