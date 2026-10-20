<?php
// Exemplul 9 - căutare într-o listă PHP, cu un formular GET
 
$orase = ['Cluj-Napoca', 'București', 'Timișoara', 'Iași', 'Brașov', 'Constanța', 'Craiova', 'Cluj (Florești)', 'Sibiu', 'Oradea', 'Ploiești', 'Arad', 'Galați', 'Pitești', 'Baia Mare'];
 
$cautare = trim($_GET['cautare'] ?? '');
$gasite  = [];
 
foreach ($orase as $oras) {
    if ($cautare === '' || stripos($oras, $cautare) !== false) {
        $gasite[] = $oras;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exemplul 9 - căutare</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h1>Exemplul 9 Caută un oraș</h1>
 
    <form method="get">
        <input type="text" name="cautare" value="<?php echo htmlspecialchars($cautare); ?>">
        <button type="submit">Caută</button>
        <a href="09_cautare.php">Toate</a>
    </form>
 
    <p>Găsite: <?php echo count($gasite); ?></p>
    <ul>
        <?php foreach ($gasite as $oras): ?>
            <li><?php echo htmlspecialchars($oras); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
