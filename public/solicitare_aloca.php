<?php
// IQ SERVICE - alocarea unei solicitări unui tehnician (Ziua 19)
// Primește formularul din fișa solicitării, schimbă tehnicianul și notează în istoric.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
cereRol(['administrator', 'operator']);
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: solicitari.php');
    exit;
}
 
$id      = (int) ($_POST['id'] ?? 0);
$agentId = (int) ($_POST['agent_id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT id, status, agent_id FROM solicitari WHERE id = :id');
$comanda->execute(['id' => $id]);
$solicitare = $comanda->fetch();
 
if (!$solicitare) {
    header('Location: solicitari.php');
    exit;
}
 
$agenti = $pdo->query("SELECT id, nume FROM utilizatori WHERE rol = 'agent' AND activ = 1")->fetchAll(PDO::FETCH_KEY_PAIR);
 
if (($agentId !== 0 && !isset($agenti[$agentId])) || $agentId === (int) $solicitare['agent_id']) {
    header('Location: solicitare.php?id=' . $id);
    exit;
}
 
$nota = $agentId === 0 ? 'Alocarea a fost retrasă.' : 'Alocată lui ' . $agenti[$agentId] . '.';
 
$pdo->beginTransaction();
 
$comanda = $pdo->prepare('UPDATE solicitari SET agent_id = :agent_id WHERE id = :id');
$comanda->execute(['agent_id' => $agentId === 0 ? null : $agentId, 'id' => $id]);
 
$comanda = $pdo->prepare('INSERT INTO solicitari_istoric (solicitare_id, utilizator_id, status_vechi, status_nou, nota)
                          VALUES (:solicitare_id, :utilizator_id, :status_vechi, :status_nou, :nota)');
$comanda->execute([
    'solicitare_id' => $id,
    'utilizator_id' => $_SESSION['utilizator']['id'],
    'status_vechi'  => $solicitare['status'],
    'status_nou'    => $solicitare['status'],
    'nota'          => $nota,
]);
 
$pdo->commit();
 
header('Location: solicitare.php?id=' . $id . '&actualizat=1');
exit;
