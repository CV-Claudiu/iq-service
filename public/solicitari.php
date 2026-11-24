<?php
// IQ SERVICE - lista solicitărilor de service (Ziua 17)
// Fiecare solicitare apare cu clientul, echipamentul, tehnicianul, prioritatea și statusul ei.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$filtre = [
    'status'     => $_GET['status'] ?? '',
    'prioritate' => $_GET['prioritate'] ?? '',
    'cautare'    => trim($_GET['cautare'] ?? ''),
];
 
$from = ' FROM solicitari
          JOIN clienti          ON clienti.id     = solicitari.client_id
          LEFT JOIN echipamente ON echipamente.id = solicitari.echipament_id
          LEFT JOIN utilizatori ON utilizatori.id = solicitari.agent_id
          WHERE clienti.activ = 1';
$parametri = [];
 
if (areRol(['agent'])) {
    $from .= ' AND solicitari.agent_id = :eu';
    $parametri['eu'] = $_SESSION['utilizator']['id'];
}
 
if ($filtre['status'] === 'deschise') {
    $from .= " AND solicitari.status IN ('noua', 'in_lucru')";
} elseif (isset($statusuri[$filtre['status']])) {
    $from .= ' AND solicitari.status = :status';
    $parametri['status'] = $filtre['status'];
}
 
if (isset($prioritati[$filtre['prioritate']])) {
    $from .= ' AND solicitari.prioritate = :prioritate';
    $parametri['prioritate'] = $filtre['prioritate'];
}
 
if ($filtre['cautare'] !== '') {
    $from .= ' AND (solicitari.titlu LIKE :cautare1 OR clienti.denumire LIKE :cautare2)';
    $parametri['cautare1'] = '%' . $filtre['cautare'] . '%';
    $parametri['cautare2'] = '%' . $filtre['cautare'] . '%';
}
 
$pePagina = 10;
 
$pagina = max(1, (int) ($_GET['pagina'] ?? 1));
 
$comanda = $pdo->prepare('SELECT COUNT(*)' . $from);
$comanda->execute($parametri);
$total = (int) $comanda->fetchColumn();
 
$pagini = max(1, (int) ceil($total / $pePagina));
 
$pagina = min($pagina, $pagini);
 
$offset = ($pagina - 1) * $pePagina;
 
$sql = 'SELECT solicitari.id, solicitari.titlu, solicitari.prioritate, solicitari.status, solicitari.creat_la,
               clienti.id AS client_id, clienti.denumire AS client,
               echipamente.denumire AS echipament,
               utilizatori.nume AS agent' . $from . ' ORDER BY solicitari.creat_la DESC, solicitari.id DESC
        LIMIT ' . $pePagina . ' OFFSET ' . $offset;
 
$comanda = $pdo->prepare($sql);
$comanda->execute($parametri);
$solicitari = $comanda->fetchAll();


 
$titlu = 'Solicitări';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1><?php echo areRol(['agent']) ? 'Solicitările mele' : 'Solicitări de service'; ?></h1>
 
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Solicitarea a fost înregistrată.</div>
    <?php endif; ?>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Toate statusurile</option>
                <option value="deschise" <?php echo $filtre['status'] === 'deschise' ? 'selected' : ''; ?>>Deschise (nouă + în lucru)</option>
                <?php foreach ($statusuri as $cheie => $text): ?>
                    <option value="<?php echo $cheie; ?>" <?php echo $cheie === $filtre['status'] ? 'selected' : ''; ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="prioritate" class="form-select">
                <option value="">Toate prioritățile</option>
                <?php foreach ($prioritati as $cheie => $text): ?>
                    <option value="<?php echo $cheie; ?>" <?php echo $cheie === $filtre['prioritate'] ? 'selected' : ''; ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="cautare" class="form-control" placeholder="Caută în titlu sau client" value="<?php echo htmlspecialchars($filtre['cautare']); ?>">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filtrează</button>
            <a href="solicitari.php" class="btn btn-outline-secondary">Toate</a>
        </div>
    </form>

 
    <p class="text-muted">Total: <?php echo $total; ?> (pagina <?php echo $pagina; ?> din <?php echo $pagini; ?>)</p>
 
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Client</th>
                <th>Titlu</th>
                <th>Echipament</th>
                <th>Prioritate</th>
                <th>Status</th>
                <th>Tehnician</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitari as $solicitare): ?>
                <tr>
                    <td><?php echo $solicitare['id']; ?></td>
                    <td><?php echo date('d.m.Y H:i', strtotime($solicitare['creat_la'])); ?></td>
                    <td><a href="client.php?id=<?php echo $solicitare['client_id']; ?>"><?php echo htmlspecialchars($solicitare['client']); ?></a></td>
                    <td><a href="solicitare.php?id=<?php echo $solicitare['id']; ?>"><?php echo htmlspecialchars($solicitare['titlu']); ?></a></td>
                    <td><?php echo htmlspecialchars($solicitare['echipament'] ?? '-'); ?></td>
                    <td><span class="badge text-bg-<?php echo $culoriPrioritate[$solicitare['prioritate']]; ?>"><?php echo $prioritati[$solicitare['prioritate']]; ?></span></td>
                    <td><span class="badge text-bg-<?php echo $culoriStatus[$solicitare['status']]; ?>"><?php echo $statusuri[$solicitare['status']]; ?></span></td>
                    <td><?php echo htmlspecialchars($solicitare['agent'] ?? 'nealocată'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>

