<?php
// IQ SERVICE - adăugare persoană de contact (Ziua 11)
// Se deschide din fișa clientului, de exemplu: contact_adauga.php?client_id=3
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$clientId = (int) ($_GET['client_id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT id, denumire FROM clienti WHERE id = :id AND activ = 1');
$comanda->execute(['id' => $clientId]);
$client = $comanda->fetch();
 
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}
 
// Valorile din formular (goale la prima deschidere a paginii)
$nume    = '';
$functie = '';
$telefon = '';
$email   = '';
$erori   = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $nume    = trim($_POST['nume'] ?? '');
    $functie = trim($_POST['functie'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $email   = trim($_POST['email'] ?? '');
 
    if ($nume === '') {
        $erori[] = 'Numele este obligatoriu.';
    }
 
    if (count($erori) === 0) {
        $sql = 'INSERT INTO contacte (client_id, nume, functie, telefon, email)
                VALUES (:client_id, :nume, :functie, :telefon, :email)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'client_id' => $clientId,
            'nume'      => $nume,
            'functie'   => $functie,
            'telefon'   => $telefon,
            'email'     => $email,
        ]);
 
        header('Location: client.php?id=' . $clientId . '&contact=adaugat');
        exit;
    }
}
 
// Titlul paginii, folosit de antet
$titlu = 'Persoană de contact nouă';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 600px;">
 
    <h1>Persoană de contact nouă</h1>
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
            <label class="form-label">Nume *</label>
            <input type="text" name="nume" class="form-control" value="<?php echo htmlspecialchars($nume); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Funcție</label>
            <input type="text" name="functie" class="form-control" value="<?php echo htmlspecialchars($functie); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="telefon" class="form-control" value="<?php echo htmlspecialchars($telefon); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        </div>
 
        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="client.php?id=<?php echo $clientId; ?>" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>