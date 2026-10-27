<?php
// Exemplul 8 - o întrebare de confirmare înainte de o acțiune importantă
 
$trimis = ($_SERVER['REQUEST_METHOD'] === 'POST');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 8 - confirmare</title>
</head>
<body>
    <h1>Confirmare înainte de acțiune</h1>
 
    <?php if ($trimis): ?>
        <p style="color: red;"><strong>Formularul a fost trimis (ai apăsat OK).</strong></p>
    <?php endif; ?>
 
    <form method="post" onsubmit="return confirm('Sigur vrei să continui?');">
        <button type="submit">Șterge ceva important</button>
    </form>
 
    <p>OK = formularul pleacă. Cancel (Anulare) = nu se întâmplă nimic.</p>
    <p><a href="08_confirmare.php">Începe din nou</a></p>
</body>
</html>
