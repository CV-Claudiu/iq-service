<?php
// Exemplul 30 - o intrare în cont „de jucărie”, fără baza de date
// Încearcă: ana@exemplu.ro cu Parola123!, apoi cu o parolă greșită.
 
$utilizatorulMeu = [
    'email'       => 'ana@exemplu.ro',
    'parola_hash' => password_hash('Parola123!', PASSWORD_DEFAULT),
];
 
$mesaj = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email  = trim($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
 
    if ($email === $utilizatorulMeu['email'] && password_verify($parola, $utilizatorulMeu['parola_hash'])) {
        $mesaj = 'Bine ai venit!';
    } else {
        $mesaj = 'E-mailul sau parola nu sunt corecte.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 30 - intrare în cont</title>
</head>
<body>
    <p><?php echo $mesaj; ?></p>
    <form method="post">
        E-mail: <input type="text" name="email"><br>
        Parolă: <input type="password" name="parola"><br>
        <button type="submit">Intră</button>
    </form>
</body>
</html>
