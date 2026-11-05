<?php
// IQ SERVICE - nomenclatorul categoriilor de echipamente (Ziua 12)
// Afișează categoriile și permite adăugarea uneia noi, pe aceeași pagină.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$denumire = '';
$erori    = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $denumire = trim($_POST['denumire'] ?? '');
 
    if ($denumire === '') {
        $erori[] = 'Denumirea categoriei este obligatorie.';
    } else {
        $comanda = $pdo->prepare('SELECT COUNT(*) FROM categorii WHERE denumire = :denumire');
        $comanda->execute(['denumire' => $denumire]);
 
        if ($comanda->fetchColumn() > 0) {
            $erori[] = 'Categoria există deja.';
        }
    }
 
    if (count($erori) === 0) {
        $comanda = $pdo->prepare('INSERT INTO categorii (denumire) VALUES (:denumire)');
        $comanda->execute(['denumire' => $denumire]);
 
        header('Location: categorii.php?adaugat=1');
        exit;
    }
}
 
$categorii = $pdo->query('SELECT id, denumire FROM categorii ORDER BY denumire')->fetchAll();
// Mesajul de confirmare, după adăugarea sau ștergerea unei persoane de contact

$mesaje = [
    'adaugat' => 'Categoria a fost adăugată.1',
    'sters'   => 'Categoria a fost ștearsă.1',
];
 
$mesaj = $mesaje[$_GET['denumire'] ?? ''] ?? '';

// Titlul paginii, folosit de antet
$titlu = 'Categorii';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 600px;">
 
    <h1>Categorii de echipamente</h1>
    <?php if ($mesaj !== ''): ?>
        <div class="alert alert-success"><?php echo $mesaj; ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['adaugat'])): ?>
       <div class="alert alert-success">Categoria a fost adăugată.2</div>
    <?php endif; ?>

    <?php if (isset($_GET['sters'])): ?>
        <div class="alert alert-success">Categoria a fost ștearsă.2</div>
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
            <input type="text" name="denumire" class="form-control" placeholder="Categorie nouă" value="<?php echo htmlspecialchars($denumire); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Adaugă</button>
        </div>
    </form>
 
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th style="width: 15%;">#</th>
                <th>Denumire</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorii as $categorie): ?>
                <tr>
                    <td><?php echo $categorie['id']; ?></td>
                    <td><?php echo htmlspecialchars($categorie['denumire']); ?></td>
                                                <td class="text-end">
                                <form action="categorie_sterge.php" method="post" class="d-inline"
                                    onsubmit="return confirm('Sigur ștergi această categorie?');">
                                    <input type="hidden" name="id" value="<?php echo $categorie['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Șterge</button>
                                </form>
                            </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
