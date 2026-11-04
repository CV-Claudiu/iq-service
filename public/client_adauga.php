<?php
// IQ SERVICE - adăugare client (Ziua 5)
// Afișează formularul; la apăsarea butonului verifică datele și le salvează.
 
define('BASE_PATH', dirname(__DIR__));
 
//renuntare ziua 9: am mutat inițializarea în app/init.php
//require BASE_PATH . '/config/env.php';
//require BASE_PATH . '/config/database.php';
 
//$config = loadEnv(BASE_PATH . '/.env');
//$pdo    = getConnection($config);
 
require BASE_PATH . '/app/init.php';
//test

// Valorile din formular (goale la prima deschidere a paginii)
$denumire = '';
$oras     = '';
$telefon  = '';
$email    = '';
$erori    = [];
 
// Dacă s-a apăsat butonul „Salvează”, formularul a fost trimis prin POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    // 1. Preluăm datele și tăiem spațiile de la capete
    $denumire = trim($_POST['denumire'] ?? '');
    $oras     = trim($_POST['oras'] ?? '');
    $telefon  = trim($_POST['telefon'] ?? '');
    $email    = trim($_POST['email'] ?? '');
 
    // 2. Verificăm câmpurile obligatorii
    if ($denumire === '') {
        $erori[] = 'Denumirea este obligatorie.';
    }
    if ($oras === '') {
        $erori[] = 'Orașul este obligatoriu.';
    }
    if ($email !== '' && !str_contains($email, '@')) {
        $erori[] = 'E-mailul nu este valid.';
    }
 
    // 3. Dacă nu sunt erori, salvăm în baza de date
    if (count($erori) === 0) {
        $sql = 'INSERT INTO clienti (denumire, oras, telefon, email)
                VALUES (:denumire, :oras, :telefon, :email)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'denumire' => $denumire,
            'oras'     => $oras,
            'telefon'  => $telefon,
            'email'    => $email,
        ]);
 
        // 4. Mergem la lista de clienți, cu un mesaj de confirmare
        header('Location: clienti.php?adaugat=1');
        exit;
    }
}
 
// Titlul paginii, folosit de antet
$titlu = 'Adaugă client';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 600px;">
 
    <h1>Adaugă client</h1>
 
    <?php if (count($erori) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach ($erori as $eroare): ?>
                <div><?php echo $eroare; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
 
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Denumire *</label>
            <input type="text" name="denumire" class="form-control" value="<?php echo htmlspecialchars($denumire); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Oraș *</label>
            <input type="text" name="oras" class="form-control" value="<?php echo htmlspecialchars($oras); ?>">
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
        <a href="clienti.php" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
