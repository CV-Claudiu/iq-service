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

// Tehnicienii activi, pentru alocare
$agenti = $pdo->query("SELECT id, nume FROM utilizatori WHERE rol = 'agent' AND activ = 1 ORDER BY nume")->fetchAll(PDO::FETCH_KEY_PAIR);


// Istoricul solicitării, cel mai nou primul
$comanda = $pdo->prepare('SELECT solicitari_istoric.*, utilizatori.nume AS utilizator
                          FROM solicitari_istoric
                          JOIN utilizatori ON utilizatori.id = solicitari_istoric.utilizator_id
                          WHERE solicitari_istoric.solicitare_id = :id
                          ORDER BY solicitari_istoric.creat_la DESC, solicitari_istoric.id DESC');
$comanda->execute(['id' => $id]);
$istoric = $comanda->fetchAll();


// Titlul paginii, folosit de antet
$titlu = 'Solicitarea nr. ' . $solicitare['id'];
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 800px;">
    
    <?php if (isset($_GET['actualizat'])): ?>
        <div class="alert alert-success">Solicitarea a fost actualizată.</div>
    <?php endif; ?>

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
 
    <?php if (areRol(['administrator', 'operator'])): ?>
        <h2 class="h5 mt-4">Tehnician</h2>
        <form action="solicitare_aloca.php" method="post" class="border rounded p-3">
            <input type="hidden" name="id" value="<?php echo $solicitare['id']; ?>">
            <div class="row g-2">
                <div class="col-md-8">
                    <select name="agent_id" class="form-select">
                        <option value="">- nealocată -</option>
                        <?php foreach ($agenti as $agentId => $nume): ?>
                            <option value="<?php echo $agentId; ?>" <?php echo $agentId === (int) $solicitare['agent_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nume); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Alocă</button>
                </div>
            </div>
        </form>
    <?php endif; ?>


    <?php if (areRol(['administrator', 'operator'])): ?>
    
        <h2 class="h5 mt-4">Schimbă statusul</h2>
        <form action="solicitare_status.php" method="post" class="border rounded p-3">
            <input type="hidden" name="id" value="<?php echo $solicitare['id']; ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <?php foreach ($statusuri as $cheie => $text): ?>
                            <option value="<?php echo $cheie; ?>" <?php echo $cheie === $solicitare['status'] ? 'selected' : ''; ?>><?php echo $text; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nota" class="form-control" placeholder="Notă: ce s-a făcut, ce urmează">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Salvează</button>
        </form>
    
    <?php endif; ?>

        <h2 class="h5 mt-4">Istoric (<?php echo count($istoric); ?>)</h2>
 
    <?php if (count($istoric) === 0): ?>
        <p class="text-muted">Nicio schimbare încă.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($istoric as $rand): ?>
                <li class="list-group-item">
                    <div class="small text-muted"><?php echo date('d.m.Y H:i', strtotime($rand['creat_la'])); ?>, <?php echo htmlspecialchars($rand['utilizator']); ?></div>
                    <?php if ($rand['status_vechi'] !== $rand['status_nou']): ?>
                        <div><?php echo $statusuri[$rand['status_vechi']]; ?> → <strong><?php echo $statusuri[$rand['status_nou']]; ?></strong></div>
                    <?php endif; ?>
                    <?php if ($rand['nota'] !== null): ?>
                        <div><?php echo nl2br(htmlspecialchars($rand['nota'])); ?></div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
 
    
    <p class="mt-3"><a href="solicitari.php" class="btn btn-secondary">Înapoi la listă</a></p>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
