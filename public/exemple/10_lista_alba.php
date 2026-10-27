<?php
// Exemplul 10 - „lista albă”: acceptăm doar valorile pe care le cunoaștem
// Încearcă: ?ordine=oras, ?ordine=denumire, apoi ?ordine=ceva_ciudat
 
$permise = ['denumire', 'oras', 'id'];
 
$ordine = $_GET['ordine'] ?? 'denumire';
 
if (!in_array($ordine, $permise)) {
    $ordine = 'denumire';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 10 - lista albă</title>
</head>
<body>
    <h1>Ordonare aleasă: <?php echo $ordine; ?></h1>
    <p>Comanda SQL ar fi: SELECT ... ORDER BY <?php echo $ordine; ?></p>
 
    <p>
        <a href="10_lista_alba.php?ordine=denumire">denumire</a> |
        <a href="10_lista_alba.php?ordine=oras">oras</a> |
        <a href="10_lista_alba.php?ordine=id">id</a> |
        <a href="10_lista_alba.php?ordine=ceva_ciudat">ceva_ciudat</a>
    </p>
</body>
</html>
