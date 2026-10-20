<?php
// Exemplul 9 - căutare într-o listă PHP, cu un formular GET
 
$orase = ['Cluj-Napoca', 'București', 'Timișoara', 'Iași', 'Brașov', 'Constanța', 'Craiova', 'Cluj (Florești)'];
 
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
    <title>Exemplul 9 - căutare</title>
</head>
<body>
    <h1>Caută un oraș</h1>
 
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
