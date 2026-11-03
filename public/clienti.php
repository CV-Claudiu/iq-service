<?php
// IQ SERVICE - lista clienților (Ziua 4, completată în zilele 5, 6, 7 și 8)
// Citește clienții din baza de date și îi afișează într-un tabel.
 
define('BASE_PATH', dirname(__DIR__));
 
//renuntare ziua 9: am mutat inițializarea în app/init.php
//require BASE_PATH . '/config/env.php';
//require BASE_PATH . '/config/database.php';
 
//$config = loadEnv(BASE_PATH . '/.env');
//$pdo    = getConnection($config);

require BASE_PATH . '/app/init.php';
 
// Ce a scris utilizatorul în căsuța de căutare (gol = toți clienții)
$cautare = trim($_GET['cautare'] ?? '');
 
// Ordonarea: acceptăm doar coloanele din „lista albă”
$permise = ['denumire', 'oras', 'id'];
$ordine  = $_GET['ordine'] ?? 'denumire';
if (!in_array($ordine, $permise)) {
    $ordine = 'denumire';
}
 
// Construim comanda SQL bucată cu bucată
$sql       = 'SELECT id, denumire, oras, telefon, email FROM clienti WHERE activ = 1';
$parametri = [];
 
if ($cautare !== '') {
    $sql .= ' AND (denumire LIKE :cautare1 OR oras LIKE :cautare2)';
    $parametri['cautare1'] = '%' . $cautare . '%';
    $parametri['cautare2'] = '%' . $cautare . '%';
}
 
$sql .= ' ORDER BY ' . $ordine . ', denumire';
 
$comanda = $pdo->prepare($sql);
$comanda->execute($parametri);
$clienti = $comanda->fetchAll();
 
// Titlul paginii, folosit de antet
$titlu = 'Clienți';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Clienți</h1>
 
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Clientul a fost adăugat.</div>
    <?php endif; ?>
 
    <?php if (isset($_GET['modificat'])): ?>
        <div class="alert alert-success">Modificările au fost salvate.</div>
    <?php endif; ?>
 
    <?php if (isset($_GET['dezactivat'])): ?>
        <div class="alert alert-warning">Clientul a fost dezactivat.</div>
    <?php endif; ?>
 
    <a href="client_adauga.php" class="btn btn-primary mb-3">+ Adaugă client</a>
 
    <form method="get" class="row g-2 mb-3">
        <input type="hidden" name="ordine" value="<?php echo $ordine; ?>">
        <div class="col-auto">
            <input type="text" name="cautare" class="form-control" placeholder="Caută după denumire sau oraș" value="<?php echo htmlspecialchars($cautare); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Caută</button>
            <a href="clienti.php" class="btn btn-outline-secondary">Toate</a>
        </div>
    </form>
 
    <p class="text-muted">Total clienți: <?php echo count($clienti); ?></p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th><a href="clienti.php?ordine=id&cautare=<?php echo urlencode($cautare); ?>" class="text-white">#</a></th>
                <th><a href="clienti.php?ordine=denumire&cautare=<?php echo urlencode($cautare); ?>" class="text-white">Denumire</a></th>
                <th><a href="clienti.php?ordine=oras&cautare=<?php echo urlencode($cautare); ?>" class="text-white">Oraș</a></th>
                <th>Telefon</th>
                <th>E-mail</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clienti as $client): ?>
                <tr>
                    <td><?php echo $client['id']; ?></td>
                    <td><a href="client.php?id=<?php echo $client['id']; ?>"><?php echo htmlspecialchars($client['denumire']); ?></a></td>
                    <td><?php echo htmlspecialchars($client['oras']); ?></td>
                    <td><?php echo htmlspecialchars($client['telefon'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($client['email'] ?? ''); ?></td>
                    <td>
                        <a href="client_editeaza.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-outline-primary">Modifică</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
    <?php if (count($clienti) === 0): ?>
        <p class="text-muted">Nu s-a găsit niciun client.</p>
    <?php endif; ?>
 
    <a href="index.php" class="btn btn-secondary">Înapoi la pagina de start</a>
 
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
