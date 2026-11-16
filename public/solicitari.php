<?php
// IQ SERVICE - lista solicitărilor de service (Ziua 17)
// Fiecare solicitare apare cu clientul, echipamentul, tehnicianul, prioritatea și statusul ei.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$sql = 'SELECT solicitari.id, solicitari.titlu, solicitari.prioritate, solicitari.status, solicitari.creat_la,
               clienti.id AS client_id, clienti.denumire AS client,
               echipamente.denumire AS echipament,
               utilizatori.nume AS agent
        FROM solicitari
        JOIN clienti          ON clienti.id     = solicitari.client_id
        LEFT JOIN echipamente ON echipamente.id = solicitari.echipament_id
        LEFT JOIN utilizatori ON utilizatori.id = solicitari.agent_id
        WHERE clienti.activ = 1
        ORDER BY solicitari.creat_la DESC';
 
$solicitari = $pdo->query($sql)->fetchAll();
 
$titlu = 'Solicitări';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Solicitări de service</h1>
 
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Solicitarea a fost înregistrată.</div>
    <?php endif; ?>
 
    <p class="text-muted">Total: <?php echo count($solicitari); ?></p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Client</th>
                <th>Titlu</th>
                <th>Echipament</th>
                <th>Prioritate</th>
                <th>Status</th>
                <th>Tehnician</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitari as $solicitare): ?>
                <tr>
                    <td><?php echo $solicitare['id']; ?></td>
                    <td><?php echo date('d.m.Y H:i', strtotime($solicitare['creat_la'])); ?></td>
                    <td><a href="client.php?id=<?php echo $solicitare['client_id']; ?>"><?php echo htmlspecialchars($solicitare['client']); ?></a></td>
                    <td><?php echo htmlspecialchars($solicitare['titlu']); ?></td>
                    <td><?php echo htmlspecialchars($solicitare['echipament'] ?? '-'); ?></td>
                    <td><span class="badge text-bg-<?php echo $culoriPrioritate[$solicitare['prioritate']]; ?>"><?php echo $prioritati[$solicitare['prioritate']]; ?></span></td>
                    <td><span class="badge text-bg-<?php echo $culoriStatus[$solicitare['status']]; ?>"><?php echo $statusuri[$solicitare['status']]; ?></span></td>
                    <td><?php echo htmlspecialchars($solicitare['agent'] ?? 'nealocată'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>

