<?php
// Exemplul 32 - paznicul de la intrare
// Fără „bilet” în sesiune, pagina nu te lasă să vezi nimic.
 
session_start();
 
if (isset($_GET['bilet'])) {
    $_SESSION['are_bilet'] = true;
}
 
if (!isset($_SESSION['are_bilet'])) {
    echo 'Nu ai bilet. <a href="32_paznic.php?bilet=1">Ia un bilet</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 32 - paznicul</title>
</head>
<body>
    <h1>Sala de concert</h1>
    <p>Ai intrat, pentru că ai bilet.</p>
</body>
</html>
