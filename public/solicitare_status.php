<?php
// IQ SERVICE - schimbarea statusului unei solicitări (Ziua 18)
// Primește formularul din fișa solicitării, schimbă statusul și scrie în istoric.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
cereRol(['administrator', 'operator']);
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: solicitari.php');
    exit;
}
 
$id        = (int) ($_POST['id'] ?? 0);
$statusNou = $_POST['status'] ?? '';
$nota      = trim($_POST['nota'] ?? '');
 
$comanda = $pdo->prepare('SELECT id, status FROM solicitari WHERE id = :id');
$comanda->execute(['id' => $id]);
$solicitare = $comanda->fetch();
 
if (!$solicitare) {
    header('Location: solicitari.php');
    exit;
}
 
if (!isset($statusuri[$statusNou]) || ($statusNou === $solicitare['status'] && $nota === '')) {
    header('Location: solicitare.php?id=' . $id);
    exit;
}
 
$pdo->beginTransaction();
 
$comanda = $pdo->prepare('UPDATE solicitari SET status = :status WHERE id = :id');
$comanda->execute(['status' => $statusNou, 'id' => $id]);
 
$comanda = $pdo->prepare('INSERT INTO solicitari_istoric (solicitare_id, utilizator_id, status_vechi, status_nou, nota)
                          VALUES (:solicitare_id, :utilizator_id, :status_vechi, :status_nou, :nota)');
$comanda->execute([
    'solicitare_id' => $id,
    'utilizator_id' => $_SESSION['utilizator']['id'],
    'status_vechi'  => $solicitare['status'],
    'status_nou'    => $statusNou,
    'nota'          => $nota === '' ? null : $nota,
]);
 
$pdo->commit();
 
header('Location: solicitare.php?id=' . $id . '&actualizat=1');
exit;
