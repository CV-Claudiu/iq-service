<?php
// IQ SERVICE - solicitare nouă (Ziua 17)
// Se deschide din fișa clientului, de exemplu: solicitare_adauga.php?client_id=2
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
cereRol(['administrator', 'operator']);
 
$clientId = (int) ($_GET['client_id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT id, denumire FROM clienti WHERE id = :id AND activ = 1');
$comanda->execute(['id' => $clientId]);
$client = $comanda->fetch();
 
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}
 
$comanda = $pdo->prepare('SELECT id, denumire FROM echipamente WHERE client_id = :id ORDER BY denumire');
$comanda->execute(['id' => $clientId]);
$echipamente = $comanda->fetchAll(PDO::FETCH_KEY_PAIR);
 
$agenti = $pdo->query("SELECT id, nume FROM utilizatori WHERE rol = 'agent' AND activ = 1 ORDER BY nume")->fetchAll(PDO::FETCH_KEY_PAIR);
 
$echipamentId = 0;
$titluCerere  = '';
$descriere    = '';
$prioritate   = 'normala';
$agentId      = 0;
$erori        = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $echipamentId = (int) ($_POST['echipament_id'] ?? 0);
    $titluCerere  = trim($_POST['titlu'] ?? '');
    $descriere    = trim($_POST['descriere'] ?? '');
    $prioritate   = $_POST['prioritate'] ?? '';
    $agentId      = (int) ($_POST['agent_id'] ?? 0);
 
    if ($titluCerere === '') {
        $erori[] = 'Titlul este obligatoriu.';
    }
    if ($echipamentId !== 0 && !isset($echipamente[$echipamentId])) {
        $erori[] = 'Alege un echipament al acestui client.';
    }
    if (!isset($prioritati[$prioritate])) {
        $erori[] = 'Alege o prioritate din listă.';
    }
    if ($agentId !== 0 && !isset($agenti[$agentId])) {
        $erori[] = 'Alege un tehnician din listă.';
    }
 
    if (count($erori) === 0) {
        $sql = 'INSERT INTO solicitari (client_id, echipament_id, titlu, descriere, prioritate, agent_id, creat_de)
                VALUES (:client_id, :echipament_id, :titlu, :descriere, :prioritate, :agent_id, :creat_de)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'client_id'     => $clientId,
            'echipament_id' => $echipamentId === 0 ? null : $echipamentId,
            'titlu'         => $titluCerere,
            'descriere'     => $descriere,
            'prioritate'    => $prioritate,
            'agent_id'      => $agentId === 0 ? null : $agentId,
            'creat_de'      => $_SESSION['utilizator']['id'],
        ]);
 
        header('Location: solicitari.php?adaugat=1');
        exit;
    }
}
 
$titlu = 'Solicitare nouă';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 700px;">
 
    <h1>Solicitare nouă</h1>
    <p class="text-muted">Pentru clientul: <?php echo htmlspecialchars($client['denumire']); ?></p>
 
    <?php if (count($erori) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach ($erori as $eroare): ?>
                <div><?php echo $eroare; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
 
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Echipament</label>
            <select name="echipament_id" class="form-select">
                <option value="">- fără echipament -</option>
                <?php foreach ($echipamente as $id => $nume): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id === $echipamentId ? 'selected' : ''; ?>><?php echo htmlspecialchars($nume); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Titlu *</label>
            <input type="text" name="titlu" class="form-control" placeholder="Pe scurt: ce s-a întâmplat?" value="<?php echo htmlspecialchars($titluCerere); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descriere</label>
            <textarea name="descriere" class="form-control" rows="4"><?php echo htmlspecialchars($descriere); ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Prioritate *</label>
                <select name="prioritate" class="form-select">
                    <?php foreach ($prioritati as $cheie => $text): ?>
                        <option value="<?php echo $cheie; ?>" <?php echo $cheie === $prioritate ? 'selected' : ''; ?>><?php echo $text; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tehnician</label>
                <select name="agent_id" class="form-select">
                    <option value="">- nealocată -</option>
                    <?php foreach ($agenti as $id => $nume): ?>
                        <option value="<?php echo $id; ?>" <?php echo $id === $agentId ? 'selected' : ''; ?>><?php echo htmlspecialchars($nume); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
 
        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="client.php?id=<?php echo $clientId; ?>" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>

