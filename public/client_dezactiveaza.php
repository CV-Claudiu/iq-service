<?php
// IQ SERVICE - dezactivare client (Ziua 7)
// Primește id-ul prin POST, marchează clientul ca inactiv și revine la listă.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);
 
// Acceptăm doar cereri trimise din formular (POST), nu un simplu link
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: clienti.php');
    exit;
}
 
$id = (int) ($_POST['id'] ?? 0);
 
$comanda = $pdo->prepare('UPDATE clienti SET activ = 0 WHERE id = :id');
$comanda->execute(['id' => $id]);
 
header('Location: clienti.php?dezactivat=1');
exit;
