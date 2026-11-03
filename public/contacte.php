<?php
// IQ SERVICE - lista tuturor persoanelor de contact (Ziua 10)
// Fiecare contact este afișat împreună cu numele clientului său (JOIN).
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$sql = 'SELECT contacte.nume, contacte.functie, contacte.telefon, contacte.email,
               clienti.id AS client_id, clienti.denumire AS client
        FROM contacte
        JOIN clienti ON clienti.id = contacte.client_id
        WHERE clienti.activ = 1
        ORDER BY clienti.denumire, contacte.nume';
 
$contacte = $pdo->query($sql)->fetchAll();
 
// Titlul paginii, folosit de antet
$titlu = 'Contacte';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Persoane de contact</h1>
    <p class="text-muted">Total: <?php echo count($contacte); ?></p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nume</th>
                <th>Funcție</th>
                <th>Telefon</th>
                <th>E-mail</th>
                <th>Client</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacte as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['nume']); ?></td>
                    <td><?php echo htmlspecialchars($contact['functie'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($contact['telefon'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($contact['email'] ?? ''); ?></td>
                    <td><a href="client.php?id=<?php echo $contact['client_id']; ?>"><?php echo htmlspecialchars($contact['client']); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>