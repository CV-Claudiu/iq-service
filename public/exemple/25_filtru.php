<?php
// Exemplul 25 - un filtru cu listă derulantă, prin GET
// Alegerea apare în adresă: 25_filtru.php?prioritate=3
 
$prioritati = [1 => 'Mică', 2 => 'Normală', 3 => 'Urgentă'];
 
$lucrari = [
    ['nume' => 'Revizie centrală',      'prioritate' => 2],
    ['nume' => 'Avarie tablou electric', 'prioritate' => 3],
    ['nume' => 'Curățare filtre',        'prioritate' => 1],
    ['nume' => 'Pompă oprită',           'prioritate' => 3],
];
 
$aleasa = (int) ($_GET['prioritate'] ?? 0);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 25 - filtru</title>
</head>
<body>
    <form method="get">
        <select name="prioritate">
            <option value="0">Toate</option>
            <?php foreach ($prioritati as $numar => $text): ?>
                <option value="<?php echo $numar; ?>" <?php echo $numar === $aleasa ? 'selected' : ''; ?>><?php echo $text; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrează</button>
    </form>
 
    <ul>
        <?php foreach ($lucrari as $lucrare): ?>
            <?php if ($aleasa === 0 || $lucrare['prioritate'] === $aleasa): ?>
                <li><?php echo $lucrare['nume']; ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</body>
</html>
