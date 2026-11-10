<?php
// Exemplul 31 - intrare și ieșire, cu sesiunea
 
session_start();
 
if (isset($_GET['intra'])) {
    $_SESSION['nume'] = 'Ana';
}
 
if (isset($_GET['iesi'])) {
    $_SESSION = [];
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 31 - intrare și ieșire</title>
</head>
<body>
    <?php if (isset($_SESSION['nume'])): ?>
        <p>Ești în cont: <?php echo $_SESSION['nume']; ?>. <a href="31_intrare_iesire.php?iesi=1">Ieșire</a></p>
    <?php else: ?>
        <p>Nu ești în cont. <a href="31_intrare_iesire.php?intra=1">Intră</a></p>
    <?php endif; ?>
</body>
</html>
