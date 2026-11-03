<?php
// IQ SERVICE - lista tuturor echipamentelor (Ziua 12)
// Fiecare echipament este afișat cu categoria și clientul lui (două JOIN-uri).
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$sql = 'SELECT echipamente.id, echipamente.denumire, echipamente.serie, echipamente.data_instalare,
               categorii.denumire AS categorie,
               clienti.id AS client_id, clienti.denumire AS client
        FROM echipamente
        JOIN categorii ON categorii.id = echipamente.categorie_id
        JOIN clienti   ON clienti.id   = echipamente.client_id
        WHERE clienti.activ = 1
        ORDER BY clienti.denumire, echipamente.denumire';
 
$echipamente = $pdo->query($sql)->fetchAll();
 
// Titlul paginii, folosit de antet
$titlu = 'Echipamente';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Echipamente</h1>
    <p class="text-muted">Total: <?php echo count($echipamente); ?></p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Echipament</th>
                <th>Categorie</th>
                <th>Serie</th>
                <th>Instalat la</th>
                <th>Client</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($echipamente as $echipament): ?>
                <tr>
                    <td><?php echo htmlspecialchars($echipament['denumire']); ?></td>
                    <td><?php echo htmlspecialchars($echipament['categorie']); ?></td>
                    <td><?php echo htmlspecialchars($echipament['serie'] ?? ''); ?></td>
                    <td><?php echo $echipament['data_instalare'] ? date('d.m.Y', strtotime($echipament['data_instalare'])) : '-'; ?></td>
                    <td><a href="client.php?id=<?php echo $echipament['client_id']; ?>"><?php echo htmlspecialchars($echipament['client']); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
