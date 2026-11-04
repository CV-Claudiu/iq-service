<?php
// IQ SERVICE - ștergerea unei categorii (Ziua 12.1)
// Primește prin POST id-ul categoriei si o șterge și revine în categorii.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: clienti.php');
    exit;
}
 
$id = (int) ($_POST['id'] ?? 0);
 
//$comanda = $pdo->prepare('SELECT id,denumire FROM categorii WHERE id = :id');
//$comanda->execute(['id' => $id]);
//$contact = $comanda->fetch();
 
if (!$contact) {
    header('Location: clienti.php');
    exit;
}
 
$comanda = $pdo->prepare('DELETE FROM categorii WHERE id = :id');
$comanda->execute(['id' => $id]);
 
header('Location: categorii.php?id=' . $contact['id'] . '&contact=sters');

exit;