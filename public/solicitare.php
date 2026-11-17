<?php
// IQ SERVICE - fișa unei solicitări (Ziua 18)
// Toate datele unei solicitări. Aici se schimbă statusul și se vede istoricul.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$id = (int) ($_GET['id'] ?? 0);
 
$sql = 'SELECT solicitari.*,
               clienti.denumire AS client,
               echipamente.denumire AS echipament, echipamente.serie,
               agent.nume AS agent,
               autor.nume AS autor
        FROM solicitari
        JOIN clienti                   ON clienti.id     = solicitari.client_id
        LEFT JOIN echipamente          ON echipamente.id = solicitari.echipament_id
        LEFT JOIN utilizatori AS agent ON agent.id       = solicitari.agent_id
        JOIN utilizatori AS autor      ON autor.id       = solicitari.creat_de
        WHERE solicitari.id = :id';
 
$comanda = $pdo->prepare($sql);
$comanda->execute(['id' => $id]);
 
$solicitare = $comanda->fetch();
 
if (!$solicitare) {
    echo 'Solicitarea nu există. <a href="solicitari.php">Înapoi la listă</a>';
    exit;
}
 
// Titlul paginii, folosit de antet
$titlu = 'Solicitarea nr. ' . $solicitare['id'];
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 800px;">
 
    <h1>Solicitarea nr. <?php echo $solicitare['id']; ?>: <?php echo htmlspecialchars($solicitare['titlu']); ?></h1>
 
    <p>
        <span class="badge fs-6 text-bg-<?php echo $culoriPrioritate[$solicitare['prioritate']]; ?>"><?php echo $prioritati[$solicitare['prioritate']]; ?></span>
        <span class="badge fs-6 text-bg-<?php echo $culoriStatus[$solicitare['status']]; ?>"><?php echo $statusuri[$solicitare['status']]; ?></span>
    </p>
 
    <table class="table">
        <tr>
            <th style="width: 30%;">Client</th>
            <td><a href="client.php?id=<?php echo $solicitare['client_id']; ?>"><?php echo htmlspecialchars($solicitare['client']); ?></a></td>
        </tr>
        <tr>
            <th>Echipament</th>
            <td><?php echo htmlspecialchars($solicitare['echipament'] ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Serie</th>
            <td><?php echo htmlspecialchars($solicitare['serie'] ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Tehnician</th>
            <td><?php echo htmlspecialchars($solicitare['agent'] ?? 'nealocată'); ?></td>
        </tr>
        <tr>
            <th>Înregistrată</th>
            <td><?php echo date('d.m.Y H:i', strtotime($solicitare['creat_la'])); ?>, de <?php echo htmlspecialchars($solicitare['autor']); ?></td>
        </tr>
    </table>
 
    <h2 class="h5">Descriere</h2>
    <div class="border rounded p-3 bg-light">
        <?php echo nl2br(htmlspecialchars($solicitare['descriere'] ?? '')); ?>
    </div>
 
    <p class="mt-3"><a href="solicitari.php" class="btn btn-secondary">Înapoi la listă</a></p>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
