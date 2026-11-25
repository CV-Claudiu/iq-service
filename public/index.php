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


// Titlul paginii, folosit de antet
$titlu = 'Pagina de start';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Bun venit<?php echo $numeUtilizator !== '' ? ', ' . htmlspecialchars($numeUtilizator) : ''; ?>!</h1>
    <p class="text-muted">IQ SERVICE - aplicație CRM pentru service echipamente de automatizare</p>
 
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
