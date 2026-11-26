<?php
// IQ SERVICE - exportul solicitărilor dintr-o perioadă, ca fișier CSV (Ziua 23)
// Se deschide din pagina Rapoarte, cu aceeași perioadă: export_solicitari.php?de_la=...&pana_la=...
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
cereRol(['administrator', 'operator']);
 
$deLa   = $_GET['de_la'] ?? date('Y-m-01');
$panaLa = $_GET['pana_la'] ?? date('Y-m-d');
if (strtotime($deLa) === false || strtotime($panaLa) === false) {
    $deLa   = date('Y-m-01');
    $panaLa = date('Y-m-d');
}
$deLa   = date('Y-m-d', strtotime($deLa));
$panaLa = date('Y-m-d', strtotime($panaLa));
 
$comanda = $pdo->prepare('SELECT solicitari.id, solicitari.creat_la, solicitari.titlu, solicitari.prioritate, solicitari.status,
                                 clienti.denumire AS client, echipamente.denumire AS echipament, utilizatori.nume AS agent
                          FROM solicitari
                          JOIN clienti          ON clienti.id     = solicitari.client_id
                          LEFT JOIN echipamente ON echipamente.id = solicitari.echipament_id
                          LEFT JOIN utilizatori ON utilizatori.id = solicitari.agent_id
                          WHERE solicitari.creat_la >= :de_la AND solicitari.creat_la < DATE_ADD(:pana_la, INTERVAL 1 DAY)
                          ORDER BY solicitari.creat_la');
$comanda->execute(['de_la' => $deLa, 'pana_la' => $panaLa]);
$solicitari = $comanda->fetchAll();
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="solicitari_' . $deLa . '_' . $panaLa . '.csv"');
 
$fisier = fopen('php://output', 'w');
 
fwrite($fisier, "\xEF\xBB\xBF");
 
fputcsv($fisier, ['Nr.', 'Data', 'Client', 'Echipament', 'Titlu', 'Prioritate', 'Status', 'Tehnician'], ';', '"', '');
 
foreach ($solicitari as $solicitare) {
    fputcsv($fisier, [
        $solicitare['id'],
        date('d.m.Y H:i', strtotime($solicitare['creat_la'])),
        $solicitare['client'],
        $solicitare['echipament'] ?? '',
        $solicitare['titlu'],
        $prioritati[$solicitare['prioritate']],
        $statusuri[$solicitare['status']],
        $solicitare['agent'] ?? 'nealocată',
    ], ';', '"', '');
}
 
fclose($fisier);
exit;
