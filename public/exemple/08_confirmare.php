<?php
// Exemplul 8 - o întrebare de confirmare înainte de o acțiune importantă
 
$trimis = ($_SERVER['REQUEST_METHOD'] === 'POST');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exemplul 8 - confirmare</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <h1>Confirmare stergere client</h1>
 
    <?php if ($trimis): ?>
        <p style="color: red;"><strong>Formularul a fost trimis (ai apăsat OK).</strong></p>
    <?php endif; ?>
 
    <form method="post" onsubmit="return confirm('Sigur vrei să continui?');">
        <button type="submit">OK, sterget</button>
    </form>
 
    <p>OK = formularul pleacă. Cancel (Anulare) = formularul nu pleacă.</p>
    <p><a href="08_confirmare.php">Începe din nou</a></p>
</body>
</html>
