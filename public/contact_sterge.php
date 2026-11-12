<?php
// IQ SERVICE - ștergerea unei persoane de contact (Ziua 11)
// Primește prin POST numărul contactului, îl șterge și revine în fișa clientului.
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';

cereRol(['administrator', 'operator']);
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: clienti.php');
    exit;
}
 
$id = (int) ($_POST['id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT client_id FROM contacte WHERE id = :id');
$comanda->execute(['id' => $id]);
$contact = $comanda->fetch();
 
if (!$contact) {
    header('Location: clienti.php');
    exit;
}
 
$comanda = $pdo->prepare('DELETE FROM contacte WHERE id = :id');
$comanda->execute(['id' => $id]);
 
header('Location: client.php?id=' . $contact['client_id'] . '&contact=sters');
exit;