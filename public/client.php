<?php
// IQ SERVICE - fișa clientului (Ziua 7)
// Afișează toate datele unui client și butoanele Modifică / Dezactivează.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);
 
$id = (int) ($_GET['id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT * FROM clienti WHERE id = :id AND activ = 1');
$comanda->execute(['id' => $id]);
$client = $comanda->fetch();
 
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($client['denumire']); ?> - IQ SERVICE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4" style="max-width: 700px;">
 
    <h1><?php echo htmlspecialchars($client['denumire']); ?></h1>
    <p class="text-muted">Client nr. <?php echo $client['id']; ?>, adăugat la <?php echo $client['creat_la']; ?></p>
 
    <table class="table">
        <tr>
            <th style="width: 30%;">Oraș</th>
            <td><?php echo htmlspecialchars($client['oras']); ?></td>
        </tr>
        <tr>
            <th>Telefon</th>
            <td><?php echo htmlspecialchars($client['telefon'] ?? ''); ?></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><?php echo htmlspecialchars($client['email'] ?? ''); ?></td>
        </tr>
    </table>
 
    <a href="clienti.php" class="btn btn-secondary">Înapoi la listă</a>
    <a href="client_editeaza.php?id=<?php echo $client['id']; ?>" class="btn btn-primary">Modifică</a>
    <form action="client_dezactiveaza.php" method="post" class="d-inline"
           onsubmit="return confirm('Sigur dezactivezi acest client?');">
        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
        <button type="submit" class="btn btn-danger">Dezactivează</button>
    </form>

</div>
</body>
</html>
