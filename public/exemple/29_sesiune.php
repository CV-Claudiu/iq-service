<?php
// Exemplul 29 - sesiunea: pagina își amintește de tine de la o deschidere la alta
 
session_start();
 
if (isset($_GET['uita'])) {
    unset($_SESSION['vizite']);
}
 
$_SESSION['vizite'] = ($_SESSION['vizite'] ?? 0) + 1;
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 29 - sesiunea</title>
</head>
<body>
    <p>Vizite pe această pagină: <?php echo $_SESSION['vizite']; ?></p>
    <p>
        <a href="29_sesiune.php">Încă o dată</a> |
        <a href="29_sesiune.php?uita=1">Uită-mă</a>
    </p>
</body>
</html>
