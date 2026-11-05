<?php
// IQ SERVICE - lista tuturor echipamentelor (Ziua 12)
// Fiecare echipament este afișat cu categoria și clientul lui (două JOIN-uri).
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$categorii = $pdo->query('SELECT id, denumire FROM categorii ORDER BY denumire')->fetchAll(PDO::FETCH_KEY_PAIR);
 
$categorieAleasa = (int) ($_GET['categorie'] ?? 0);
 
$sql = 'SELECT echipamente.id, echipamente.denumire, echipamente.serie, echipamente.data_instalare,
               categorii.denumire AS categorie,
               clienti.id AS client_id, clienti.denumire AS client
        FROM echipamente
        JOIN categorii ON categorii.id = echipamente.categorie_id
        JOIN clienti   ON clienti.id   = echipamente.client_id
        WHERE clienti.activ = 1';
$parametri = [];
 
if ($categorieAleasa > 0) {
    $sql .= ' AND echipamente.categorie_id = :categorie';
    $parametri['categorie'] = $categorieAleasa;
}
 
$sql .= ' ORDER BY clienti.denumire, echipamente.denumire';
 
$comanda = $pdo->prepare($sql);
$comanda->execute($parametri);
$echipamente = $comanda->fetchAll();

 
// Titlul paginii, folosit de antet
$titlu = 'Echipamente';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Echipamente</h1>
    <form method="get" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="categorie" class="form-select">
                <option value="0">Toate categoriile</option>
                <?php foreach ($categorii as $id => $nume): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id === $categorieAleasa ? 'selected' : ''; ?>><?php echo htmlspecialchars($nume); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filtrează</button>
        </div>
    </form>


    <p class="text-muted">Total: <?php echo count($echipamente); ?></p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Echipament</th>
                <th>Categorie</th>
                <th>Serie</th>
                <th>Instalat la</th>
                <th>Client</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($echipamente as $echipament): ?>
                <tr>
                    <td><?php echo htmlspecialchars($echipament['denumire']); ?></td>
                    <td><?php echo htmlspecialchars($echipament['categorie']); ?></td>
                    <td><?php echo htmlspecialchars($echipament['serie'] ?? ''); ?></td>
                    <td><?php echo $echipament['data_instalare'] ? date('d.m.Y', strtotime($echipament['data_instalare'])) : '-'; ?></td>
                    <td><a href="client.php?id=<?php echo $echipament['client_id']; ?>"><?php echo htmlspecialchars($echipament['client']); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
