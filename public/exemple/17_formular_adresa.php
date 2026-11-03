<?php
// Exemplul 17 - un formular care ține minte numărul din adresă
// Deschide: 17_formular_adresa.php?firma=2
 
$firma = (int) ($_GET['firma'] ?? 0);
$mesaj = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume  = trim($_POST['nume'] ?? '');
    $mesaj = 'Am primit persoana ' . $nume . ' pentru firma numărul ' . $firma . '.';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 17 - formular și adresă</title>
</head>
<body>
    <h1>Persoană nouă pentru firma <?php echo $firma; ?></h1>
 
    <p><?php echo htmlspecialchars($mesaj); ?></p>
 
    <form method="post">
        Nume: <input type="text" name="nume">
        <button type="submit">Trimite</button>
    </form>
</body>
</html>