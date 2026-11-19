<?php
// exemplu 38 - text pe mai multe randuri

$descriere = "Centrala afiseaza o eroare F99.\n Nu au apa calda. \n <b> suna dupa ora 10 </b>";
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplu 38 - randuri</title>
</head>
<body>
    <h2>1.Direct</h2>
    <p><?php echo $descriere; ?></p>
    <h2>2.Cu htmlspecialchars si nl2br</h2>

    <p><?php echo nl2br(htmlspecialchars($descriere)); ?></p>

    <h2>3.Doar cu nl2br</h2>

    <p><?php echo nl2br($descriere); ?></p>

</body>
</html>