<?php
// IQ SERVICE - modificare client (Ziua 6)
// Încarcă clientul după id, afișează formularul completat și salvează modificările.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);
 
// 1. Ce client modificăm? Numărul vine din adresă: client_editeaza.php?id=3
$id = (int) ($_GET['id'] ?? 0);
 
// 2. Citim clientul din baza de date
$comanda = $pdo->prepare('SELECT * FROM clienti WHERE id = :id');
$comanda->execute(['id' => $id]);
$client = $comanda->fetch();
 
// Dacă nu există un client cu acest id, oprim pagina cu un mesaj
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}
 
// 3. Valorile din formular pornesc de la datele clientului
$denumire = $client['denumire'];
$oras     = $client['oras'];
$telefon  = $client['telefon'] ?? '';
$email    = $client['email'] ?? '';
$erori    = [];
 
// 4. Dacă s-a apăsat „Salvează”, verificăm și salvăm modificările
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $denumire = trim($_POST['denumire'] ?? '');
    $oras     = trim($_POST['oras'] ?? '');
    $telefon  = trim($_POST['telefon'] ?? '');
    $email    = trim($_POST['email'] ?? '');
 
    if ($denumire === '') {
        $erori[] = 'Denumirea este obligatorie.';
    }
    if ($oras === '') {
        $erori[] = 'Orașul este obligatoriu.';
    }
 
    if (count($erori) === 0) {
        $sql = 'UPDATE clienti
                SET denumire = :denumire, oras = :oras, telefon = :telefon, email = :email
                WHERE id = :id';
 
        $comanda = $pdo->prepare($sql);
        $comanda->execute([
            'denumire' => $denumire,
            'oras'     => $oras,
            'telefon'  => $telefon,
            'email'    => $email,
            'id'       => $id,
        ]);
 
        header('Location: clienti.php?modificat=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifică client - IQ SERVICE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4" style="max-width: 600px;">
 
    <h1>Modifică client</h1>
    <p class="text-muted">Client nr. <?php echo $client['id']; ?>, adăugat la <?php echo $client['creat_la']; ?></p>
 
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
 
        <button type="submit" class="btn btn-primary">Salvează modificările</button>
        <a href="clienti.php" class="btn btn-secondary">Renunță</a>
    </form>
 
</div>
</body>
</html>
