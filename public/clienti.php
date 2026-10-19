<?php
// IQ SERVICE - lista clienților (Ziua 4)
// Citește clienții din baza de date și îi afișează într-un tabel.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);
 
$clienti = $pdo->query('SELECT id, denumire, oras, telefon, email FROM clienti ORDER BY denumire')->fetchAll();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clienți - IQ SERVICE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4">
 
    <h1>Clienți</h1>
     
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Clientul a fost adăugat.</div>
    <?php endif; ?>
    <?php if (isset($_GET['modificat'])): ?>
        <div class="alert alert-success">Modificările au fost salvate.</div>
    <?php endif; ?>

    <a href="client_adauga.php" class="btn btn-primary mb-3">+ Adaugă client</a>
 
    <p class="text-muted">Total clienți: <?php echo count($clienti); ?></p>

 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Denumire</th>
                <th>Oraș</th>
                <th>Telefon</th>
                <th>E-mail</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clienti as $client): ?>
                <tr>
                    <td><?php echo $client['id']; ?></td>
                    <td><a href="client.php?id=<?php echo $client['id']; ?>"><?php echo htmlspecialchars($client['denumire']); ?></a></td>
                    <td><?php echo htmlspecialchars($client['oras']); ?></td>
                    <td><?php echo htmlspecialchars($client['telefon'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($client['email'] ?? ''); ?></td>
                    <td>
                        <a href="client_editeaza.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-outline-primary">Modifică</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
    <a href="index.php" class="btn btn-secondary">Înapoi la pagina de start</a>
 
</div>
</body>
</html>
