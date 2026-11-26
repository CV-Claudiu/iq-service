<?php
// IQ SERVICE - rapoarte pe o perioadă (Ziua 23)
// Solicitările înregistrate pe status și activitatea fiecărui om, între două date alese.
 
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
cereRol(['administrator', 'operator']);
 
$deLa  = $_GET['de_la'] ?? date('Y-m-01');
$panaLa = $_GET['pana_la'] ?? date('Y-m-d');
$eroare = '';
 
if (strtotime($deLa) === false || strtotime($panaLa) === false) {
    $deLa   = date('Y-m-01');
    $panaLa = date('Y-m-d');
    $eroare = 'Datele nu sunt corecte. Am ales luna curentă.';
}
 
$deLa   = date('Y-m-d', strtotime($deLa));
$panaLa = date('Y-m-d', strtotime($panaLa));
 
if ($deLa > $panaLa) {
    $eroare = 'Data de început este după data de sfârșit.';
}
 
$parametri = ['de_la' => $deLa, 'pana_la' => $panaLa];
 
$comanda = $pdo->prepare('SELECT status, COUNT(*) FROM solicitari
                          WHERE creat_la >= :de_la AND creat_la < DATE_ADD(:pana_la, INTERVAL 1 DAY)
                          GROUP BY status');
$comanda->execute($parametri);
$peStatus = $comanda->fetchAll(PDO::FETCH_KEY_PAIR);
 
$totalPerioada = array_sum($peStatus);
 
// Titlul paginii, folosit de antet
$titlu = 'Rapoarte';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Rapoarte</h1>
 
    <form method="get" class="row g-2 mb-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">De la</label>
            <input type="date" name="de_la" class="form-control" value="<?php echo $deLa; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Până la</label>
            <input type="date" name="pana_la" class="form-control" value="<?php echo $panaLa; ?>">
        </div>
        <div class="col-md-6 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Arată raportul</button>
        </div>
    </form>
 
    <?php if ($eroare !== ''): ?>
        <div class="alert alert-warning"><?php echo $eroare; ?></div>
    <?php endif; ?>
 
    <h2 class="h5 mt-4">Solicitări înregistrate între <?php echo date('d.m.Y', strtotime($deLa)); ?> și <?php echo date('d.m.Y', strtotime($panaLa)); ?></h2>
    <table class="table table-sm" style="max-width: 500px;">
        <?php foreach ($statusuri as $cheie => $text): ?>
            <tr>
                <td><span class="badge text-bg-<?php echo $culoriStatus[$cheie]; ?>"><?php echo $text; ?></span></td>
                <td class="text-end"><?php echo $peStatus[$cheie] ?? 0; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="table-light fw-bold">
            <td>Total</td>
            <td class="text-end"><?php echo $totalPerioada; ?></td>
        </tr>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
