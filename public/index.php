<?php
// IQ SERVICE - pagina de start (Ziua 3, refăcută în Ziua 15)
// Pagina de bun venit: câteva numere despre ce avem în aplicație.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$numarClienti     = $pdo->query('SELECT COUNT(*) FROM clienti WHERE activ = 1')->fetchColumn();
$numarEchipamente = $pdo->query('SELECT COUNT(*) FROM echipamente JOIN clienti ON clienti.id = echipamente.client_id WHERE clienti.activ = 1')->fetchColumn();
$numarContacte    = $pdo->query('SELECT COUNT(*) FROM contacte JOIN clienti ON clienti.id = contacte.client_id WHERE clienti.activ = 1')->fetchColumn();
 
$numeUtilizator = $_SESSION['utilizator']['nume'] ?? '';

// Tabloul de bord: solicitările, pentru cartonașele de sus
 
$conditieAgent = '';
$parametri     = [];
if (areRol(['agent'])) {
    $conditieAgent   = ' AND solicitari.agent_id = :eu';
    $parametri['eu'] = $_SESSION['utilizator']['id'];
}
 
$comanda = $pdo->prepare('SELECT solicitari.status, COUNT(*) FROM solicitari
                          JOIN clienti ON clienti.id = solicitari.client_id
                          WHERE clienti.activ = 1' . $conditieAgent . '
                          GROUP BY solicitari.status');
$comanda->execute($parametri);
$peStatus = $comanda->fetchAll(PDO::FETCH_KEY_PAIR);
 
$deschise = ($peStatus['noua'] ?? 0) + ($peStatus['in_lucru'] ?? 0);
$deInchis = $peStatus['rezolvata'] ?? 0;
 
$comanda = $pdo->prepare("SELECT COUNT(*) FROM solicitari
                          JOIN clienti ON clienti.id = solicitari.client_id
                          WHERE clienti.activ = 1 AND solicitari.prioritate = 'urgenta'
                            AND solicitari.status IN ('noua', 'in_lucru')" . $conditieAgent);
$comanda->execute($parametri);
$urgente = $comanda->fetchColumn();
 
$nealocate = $pdo->query("SELECT COUNT(*) FROM solicitari
                          JOIN clienti ON clienti.id = solicitari.client_id
                          WHERE clienti.activ = 1 AND solicitari.agent_id IS NULL
                            AND solicitari.status IN ('noua', 'in_lucru')")->fetchColumn();

// Solicitări deschise pe tehnician (doar pentru administrator și operator)
$peTehnician = [];
$maxim       = 1;
if (areRol(['administrator', 'operator'])) {
    $peTehnician = $pdo->query("SELECT utilizatori.nume, COUNT(solicitari.id) AS deschise
                                FROM utilizatori
                                LEFT JOIN solicitari ON solicitari.agent_id = utilizatori.id
                                                    AND solicitari.status IN ('noua', 'in_lucru')
                                WHERE utilizatori.rol = 'agent' AND utilizatori.activ = 1
                                GROUP BY utilizatori.id, utilizatori.nume
                                ORDER BY deschise DESC")->fetchAll();
 
    foreach ($peTehnician as $rand) {
        $maxim = max($maxim, $rand['deschise']);
    }
}


// Titlul paginii, folosit de antet
$titlu = 'Pagina de start';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Bun venit<?php echo $numeUtilizator !== '' ? ', ' . htmlspecialchars($numeUtilizator) : ''; ?>!</h1>
    <p class="text-muted">IQ SERVICE - aplicație CRM pentru service echipamente de automatizare</p>
 
    <h2 class="h5 mt-4"><?php echo areRol(['agent']) ? 'Solicitările mele' : 'Solicitări'; ?></h2>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-center border-primary h-100">
                <div class="card-body">
                    <div class="display-6"><?php echo $deschise; ?></div>
                    <a href="solicitari.php?status=deschise">deschise</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger h-100">
                <div class="card-body">
                    <div class="display-6 text-danger"><?php echo $urgente; ?></div>
                    <a href="solicitari.php?status=deschise&prioritate=urgenta">urgente, deschise</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success h-100">
                <div class="card-body">
                    <div class="display-6"><?php echo $deInchis; ?></div>
                    <a href="solicitari.php?status=rezolvata">rezolvate, de închis</a>
                </div>
            </div>
        </div>
        <?php if (areRol(['administrator', 'operator'])): ?>
            <div class="col-md-3">
                <div class="card text-center border-warning h-100">
                    <div class="card-body">
                        <div class="display-6"><?php echo $nealocate; ?></div>
                        <span>deschise, fără tehnician</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
 
   
    <?php if (areRol(['administrator', 'operator'])): ?>
        <h2 class="h5 mt-4">Solicitări deschise pe tehnician</h2>
        <table class="table table-sm" style="max-width: 600px;">
            <?php foreach ($peTehnician as $rand): ?>
                <tr>
                    <td style="width: 35%;"><?php echo htmlspecialchars($rand['nume']); ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo round($rand['deschise'] / $maxim * 100); ?>%;"></div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 10%;"><?php echo $rand['deschise']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
   
   
    <h2 class="h5 mt-4">Date generale</h2>
    
    <div class="row g-3 mt-2">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6"><?php echo $numarClienti; ?></div>
                    <a href="clienti.php">clienți activi</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6"><?php echo $numarEchipamente; ?></div>
                    <a href="echipamente.php">echipamente</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6"><?php echo $numarContacte; ?></div>
                    <a href="contacte.php">persoane de contact</a>
                </div>
            </div>
        </div>
    </div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
