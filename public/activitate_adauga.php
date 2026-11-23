<?php
// IQ SERVICE - activitate nouă (Ziua 20)
// Se deschide din fișa clientului (activitate_adauga.php?client_id=2)
// sau din fișa unei solicitări (activitate_adauga.php?client_id=2&solicitare_id=1).
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$clientId     = (int) ($_GET['client_id'] ?? 0);
$solicitareId = (int) ($_GET['solicitare_id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT id, denumire FROM clienti WHERE id = :id AND activ = 1');
$comanda->execute(['id' => $clientId]);
$client = $comanda->fetch();
 
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}
 
$sql = "SELECT id, titlu FROM solicitari WHERE client_id = :client_id AND status <> 'inchisa'";
$parametri = ['client_id' => $clientId];
 
if (areRol(['agent'])) {
    $sql .= ' AND agent_id = :eu';
    $parametri['eu'] = $_SESSION['utilizator']['id'];
}
$sql .= ' ORDER BY id DESC';
 
$comanda = $pdo->prepare($sql);
$comanda->execute($parametri);
$solicitari = $comanda->fetchAll(PDO::FETCH_KEY_PAIR);
 
$tip           = 'telefon';
$dataActivitate = date('Y-m-d\TH:i');
$durataText    = '';
$descriere     = '';
$erori         = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $tip            = $_POST['tip'] ?? '';
    $dataActivitate = $_POST['data_activitate'] ?? '';
    $durataText     = trim($_POST['durata'] ?? '');
    $descriere      = trim($_POST['descriere'] ?? '');
    $solicitareId   = (int) ($_POST['solicitare_id'] ?? 0);
 
    if (!isset($tipuriActivitate[$tip])) {
        $erori[] = 'Alege tipul activității.';
    }
    if (strtotime($dataActivitate) === false) {
        $erori[] = 'Data și ora nu sunt corecte.';
    }
    if ($durataText !== '' && (!ctype_digit($durataText) || (int) $durataText === 0)) {
        $erori[] = 'Durata se scrie în minute, ca număr întreg (de exemplu 45).';
    }
    if ($descriere === '') {
        $erori[] = 'Scrie pe scurt ce s-a făcut.';
    }
    if ($solicitareId !== 0 && !isset($solicitari[$solicitareId])) {
        $erori[] = 'Alege o solicitare din listă.';
    }
 
    if (count($erori) === 0) {
        $sql = 'INSERT INTO activitati (client_id, solicitare_id, utilizator_id, tip, data_activitate, durata_minute, descriere)
                VALUES (:client_id, :solicitare_id, :utilizator_id, :tip, :data_activitate, :durata_minute, :descriere)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'client_id'       => $clientId,
            'solicitare_id'   => $solicitareId === 0 ? null : $solicitareId,
            'utilizator_id'   => $_SESSION['utilizator']['id'],
            'tip'             => $tip,
            'data_activitate' => date('Y-m-d H:i:s', strtotime($dataActivitate)),
            'durata_minute'   => $durataText === '' ? null : (int) $durataText,
            'descriere'       => $descriere,
        ]);
 
        if ($solicitareId !== 0) {
            header('Location: solicitare.php?id=' . $solicitareId . '&actualizat=1');
        } else {
            header('Location: client.php?id=' . $clientId . '&activitate=adaugata');
        }
        exit;
    }
}
 
$titlu = 'Activitate nouă';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 700px;">
 
    <h1>Activitate nouă</h1>
    <p class="text-muted">Pentru clientul: <?php echo htmlspecialchars($client['denumire']); ?></p>
 
    <?php if (count($erori) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach ($erori as $eroare): ?>
                <div><?php echo $eroare; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
 
    <form method="post">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tip *</label>
                <select name="tip" class="form-select">
                    <?php foreach ($tipuriActivitate as $cheie => $text): ?>
                        <option value="<?php echo $cheie; ?>" <?php echo $cheie === $tip ? 'selected' : ''; ?>><?php echo $text; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5 mb-3">
                <label class="form-label">Data și ora *</label>
                <input type="datetime-local" name="data_activitate" class="form-control" value="<?php echo htmlspecialchars($dataActivitate); ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Durata (min)</label>
                <input type="text" name="durata" class="form-control" value="<?php echo htmlspecialchars($durataText); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Solicitare</label>
            <select name="solicitare_id" class="form-select">
                <option value="">- nu ține de o solicitare -</option>
                <?php foreach ($solicitari as $id => $titluSolicitare): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id === $solicitareId ? 'selected' : ''; ?>>nr. <?php echo $id; ?>: <?php echo htmlspecialchars($titluSolicitare); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ce s-a făcut *</label>
            <textarea name="descriere" class="form-control" rows="4"><?php echo htmlspecialchars($descriere); ?></textarea>
        </div>
 
        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="client.php?id=<?php echo $clientId; ?>" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
