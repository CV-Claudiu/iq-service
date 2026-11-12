<?php
// IQ SERVICE - adăugarea unui utilizator (Ziua 14)
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';

cereRol(['administrator']);
 
$roluri = [
    'administrator' => 'Administrator',
    'operator'      => 'Operator (dispecer)',
    'agent'         => 'Agent (tehnician)',
];
 
$nume  = '';
$email = '';
$rol   = '';
$erori = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $nume   = trim($_POST['nume'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
    $rol    = $_POST['rol'] ?? '';
 
    if ($nume === '') {
        $erori[] = 'Numele este obligatoriu.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erori[] = 'Adresa de e-mail nu este corectă.';
    }
    if (strlen($parola) < 8) {
        $erori[] = 'Parola trebuie să aibă cel puțin 8 caractere.';
    }
    if (!isset($roluri[$rol])) {
        $erori[] = 'Alege un rol din listă.';
    }
 
    if (count($erori) === 0) {
        $comanda = $pdo->prepare('SELECT COUNT(*) FROM utilizatori WHERE email = :email');
        $comanda->execute(['email' => $email]);
        if ($comanda->fetchColumn() > 0) {
            $erori[] = 'Există deja un utilizator cu acest e-mail.';
        }
    }
 
    if (count($erori) === 0) {
        $sql = 'INSERT INTO utilizatori (nume, email, parola_hash, rol)
                VALUES (:nume, :email, :parola_hash, :rol)';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'nume'        => $nume,
            'email'       => $email,
            'parola_hash' => password_hash($parola, PASSWORD_DEFAULT),
            'rol'         => $rol,
        ]);
 
        header('Location: utilizatori.php?adaugat=1');
        exit;
    }
}
 
// Titlul paginii, folosit de antet
$titlu = 'Utilizator nou';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 600px;">
 
    <h1>Utilizator nou</h1>
 
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
            <label class="form-label">E-mail *</label>
            <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Parolă * (cel puțin 8 caractere)</label>
            <input type="password" name="parola" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Rol *</label>
            <select name="rol" class="form-select">
                <option value="">- alege rolul -</option>
                <?php foreach ($roluri as $cheie => $text): ?>
                    <option value="<?php echo $cheie; ?>" <?php echo $cheie === $rol ? 'selected' : ''; ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
 
        <button type="submit" class="btn btn-primary">Salvează</button>
        <a href="utilizatori.php" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
