<?php
// IQ SERVICE - intrarea în cont (Ziua 15)
// Verifică e-mailul și parola și ține minte în sesiune cine a intrat.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$email  = '';
$eroare = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $email  = trim($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
 
    $comanda = $pdo->prepare('SELECT id, nume, rol, parola_hash FROM utilizatori WHERE email = :email AND activ = 1');
    $comanda->execute(['email' => $email]);
    $utilizator = $comanda->fetch();
 
    if ($utilizator && password_verify($parola, $utilizator['parola_hash'])) {
 
        session_regenerate_id(true);
 
        $_SESSION['utilizator'] = [
            'id'   => $utilizator['id'],
            'nume' => $utilizator['nume'],
            'rol'  => $utilizator['rol'],
        ];
 
        header('Location: index.php');
        exit;
    }
 
    $eroare = 'E-mailul sau parola nu sunt corecte.';
}
 
// Titlul paginii, folosit de antet
$titlu = 'Intrare în cont';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 400px;">
 
    <h1>Intrare în cont</h1>
 
    <?php if ($eroare !== ''): ?>
        <div class="alert alert-danger"><?php echo $eroare; ?></div>
    <?php endif; ?>
 
    <form method="post">
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Parolă</label>
            <input type="password" name="parola" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Intră</button>
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
