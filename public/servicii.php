<?php
// IQ SERVICE - nomenclatorul serviciilor, cu prețuri (Ziua 14)
// Afișează serviciile și permite adăugarea unuia nou, pe aceeași pagină.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$denumire = '';
$pret     = '';
$erori    = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $denumire = trim($_POST['denumire'] ?? '');
    $pret     = trim($_POST['pret'] ?? '');
 
    $pretPentruBaza = str_replace(',', '.', $pret);
 
    if ($denumire === '') {
        $erori[] = 'Denumirea serviciului este obligatorie.';
    }
    if (!is_numeric($pretPentruBaza) || $pretPentruBaza <= 0) {
        $erori[] = 'Prețul trebuie să fie un număr mai mare ca zero (de exemplu 250 sau 250,50).';
    }
 
    if (count($erori) === 0) {
        $comanda = $pdo->prepare('SELECT COUNT(*) FROM servicii WHERE denumire = :denumire');
        $comanda->execute(['denumire' => $denumire]);
        if ($comanda->fetchColumn() > 0) {
            $erori[] = 'Serviciul există deja.';
        }
    }
 
    if (count($erori) === 0) {
        $comanda = $pdo->prepare('INSERT INTO servicii (denumire, pret) VALUES (:denumire, :pret)');
        $comanda->execute(['denumire' => $denumire, 'pret' => $pretPentruBaza]);
 
        header('Location: servicii.php?adaugat=1');
        exit;
    }
}
 
$servicii = $pdo->query('SELECT id, denumire, pret FROM servicii ORDER BY denumire')->fetchAll();
 
// Titlul paginii, folosit de antet
$titlu = 'Servicii';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 700px;">
 
    <h1>Servicii</h1>
 
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Serviciul a fost adăugat.</div>
    <?php endif; ?>
 
    <?php if (count($erori) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach ($erori as $eroare): ?>
                <div><?php echo $eroare; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
 
    <form method="post" class="row g-2 mb-4">
        <div class="col">
            <input type="text" name="denumire" class="form-control" placeholder="Serviciu nou" value="<?php echo htmlspecialchars($denumire); ?>">
        </div>
        <div class="col-3">
            <input type="text" name="pret" class="form-control" placeholder="Preț (lei)" value="<?php echo htmlspecialchars($pret); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Adaugă</button>
        </div>
    </form>
 
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Serviciu</th>
                <th class="text-end">Preț</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicii as $serviciu): ?>
                <tr>
                    <td><?php echo htmlspecialchars($serviciu['denumire']); ?></td>
                    <td class="text-end"><?php echo number_format($serviciu['pret'], 2, ',', '.'); ?> lei</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
