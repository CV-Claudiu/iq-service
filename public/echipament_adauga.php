<?php
// IQ SERVICE - adăugare echipament (Ziua 13)
// Se deschide din fișa clientului, de exemplu: echipament_adauga.php?client_id=2
 
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
 
$categorii = $pdo->query('SELECT id, denumire FROM categorii ORDER BY denumire')->fetchAll(PDO::FETCH_KEY_PAIR);
 
// Valorile din formular (goale la prima deschidere a paginii)
$categorieId   = 0;
$denumire      = '';
$serie         = '';
$dataInstalare = '';
$observatii    = '';
$erori         = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $categorieId   = (int) ($_POST['categorie_id'] ?? 0);
    $denumire      = trim($_POST['denumire'] ?? '');
    $serie         = trim($_POST['serie'] ?? '');
    $dataInstalare = trim($_POST['data_instalare'] ?? '');
    $observatii    = trim($_POST['observatii'] ?? '');
 
    if (!isset($categorii[$categorieId])) {
        $erori[] = 'Alege o categorie din listă.';
    }
    if ($denumire === '') {
        $erori[] = 'Denumirea echipamentului este obligatorie.';
    }
 
    if (count($erori) === 0) {
        $sql = 'INSERT INTO echipamente (client_id, categorie_id, denumire, serie, data_instalare, observatii)
                VALUES (:client_id, :categorie_id, :denumire, :serie, :data_instalare, :observatii)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'client_id'      => $clientId,
            'categorie_id'   => $categorieId,
            'denumire'       => $denumire,
            'serie'          => $serie,
            'data_instalare' => $dataInstalare,
            'observatii'     => $observatii,
        ]);
 
        header('Location: client.php?id=' . $clientId . '&echipament=adaugat');
        exit;
    }
}
 
// Titlul paginii, folosit de antet
$titlu = 'Echipament nou';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 600px;">
 
    <h1>Echipament nou</h1>
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
            <label class="form-label">Categorie *</label>
            <select name="categorie_id" class="form-select">
                <option value="">- alege categoria -</option>
                <?php foreach ($categorii as $id => $nume): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id === $categorieId ? 'selected' : ''; ?>><?php echo htmlspecialchars($nume); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Denumire *</label>
            <input type="text" name="denumire" class="form-control" value="<?php echo htmlspecialchars($denumire); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Serie</label>
            <input type="text" name="serie" class="form-control" value="<?php echo htmlspecialchars($serie); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Data instalării</label>
            <input type="date" name="data_instalare" class="form-control" value="<?php echo htmlspecialchars($dataInstalare); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Observații</label>
            <input type="text" name="observatii" class="form-control" value="<?php echo htmlspecialchars($observatii); ?>">
        </div>
 
        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="client.php?id=<?php echo $clientId; ?>" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
