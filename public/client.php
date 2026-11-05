<?php
// IQ SERVICE - fișa clientului (Ziua 7)
// Afișează toate datele unui client și butoanele Modifică / Dezactivează.
 
define('BASE_PATH', dirname(__DIR__));
 
//renuntare ziua 9: am mutat inițializarea în app/init.php
//require BASE_PATH . '/config/env.php';
//require BASE_PATH . '/config/database.php';
 
//$config = loadEnv(BASE_PATH . '/.env');
//$pdo    = getConnection($config);
 
require BASE_PATH . '/app/init.php';
 
$id = (int) ($_GET['id'] ?? 0);
 
$comanda = $pdo->prepare('SELECT * FROM clienti WHERE id = :id AND activ = 1');
$comanda->execute(['id' => $id]);
$client = $comanda->fetch();
 
if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}

// Persoanele de contact ale acestui client
$comanda = $pdo->prepare('SELECT * FROM contacte WHERE client_id = :id ORDER BY nume');
$comanda->execute(['id' => $id]);
$contacte = $comanda->fetchAll();

// Echipamentele acestui client, fiecare cu numele categoriei
$comanda = $pdo->prepare('SELECT echipamente.*, categorii.denumire AS categorie
                          FROM echipamente
                          JOIN categorii ON categorii.id = echipamente.categorie_id
                          WHERE echipamente.client_id = :id
                          ORDER BY echipamente.denumire');
$comanda->execute(['id' => $id]);
$echipamente = $comanda->fetchAll();


// Mesajul de confirmare, după adăugarea sau ștergerea unei persoane de contact
$mesaje = [
    'adaugat' => 'Persoana de contact a fost adăugată.',
    'sters'   => 'Persoana de contact a fost ștearsă.',
];
 
$mesaj = $mesaje[$_GET['contact'] ?? ''] ?? '';

if (($_GET['echipament'] ?? '') === 'adaugat') {
    $mesaj = 'Echipamentul a fost adăugat.';
}


// Titlul paginii, folosit de antet
$titlu = $client['denumire'];
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
<div style="max-width: 700px;">
    <?php if ($mesaj !== ''): ?>
        <div class="alert alert-success"><?php echo $mesaj; ?></div>
    <?php endif; ?>

 
    <h1><?php echo htmlspecialchars($client['denumire']); ?></h1>
    <p class="text-muted">Client nr. <?php echo $client['id']; ?>, adăugat la <?php echo $client['creat_la']; ?></p>
 
    <table class="table">
        <tr>
            <th style="width: 30%;">Oraș</th>
            <td><?php echo htmlspecialchars($client['oras']); ?></td>
        </tr>
        <tr>
            <th>Telefon</th>
            <td><?php echo htmlspecialchars($client['telefon'] ?? ''); ?></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><?php echo htmlspecialchars($client['email'] ?? ''); ?></td>
        </tr>
    </table>
 
    <a href="clienti.php" class="btn btn-secondary">Înapoi la listă</a>
    <a href="client_editeaza.php?id=<?php echo $client['id']; ?>" class="btn btn-primary">Modifică</a>
 
    <form action="client_dezactiveaza.php" method="post" class="d-inline"
          onsubmit="return confirm('Sigur dezactivezi acest client?');">
        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
        <button type="submit" class="btn btn-danger">Dezactivează</button>

    <h2 class="h4 mt-5">Echipamente (<?php echo count($echipamente); ?>)</h2>

    <a href="echipament_adauga.php?client_id=<?php echo $client['id']; ?>" class="btn btn-sm btn-success mb-3">Adaugă echipament</a>
 
    <?php if (count($echipamente) === 0): ?>
        <p class="text-muted">Clientul nu are echipamente înregistrate.</p>
    <?php else: ?>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Echipament</th>
                    <th>Categorie</th>
                    <th>Serie</th>
                    <th>Instalat la</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($echipamente as $echipament): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($echipament['denumire']); ?></td>
                        <td><?php echo htmlspecialchars($echipament['categorie']); ?></td>
                        <td><?php echo htmlspecialchars($echipament['serie'] ?? ''); ?></td>
                        <td><?php echo $echipament['data_instalare'] ? date('d.m.Y', strtotime($echipament['data_instalare'])) : '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

        
        <h2 class="h4 mt-5">Persoane de contact (<?php echo count($contacte); ?>)</h2>
        <a href="contact_adauga.php?client_id=<?php echo $client['id']; ?>" class="btn btn-sm btn-success mb-3">Adaugă persoană de contact</a>

        <?php if (count($contacte) === 0): ?>
            <p class="text-muted">Clientul nu are persoane de contact.</p>
        <?php else: ?>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Funcție</th>
                        <th>Telefon</th>
                        <th>E-mail</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacte as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['nume']); ?></td>
                            <td><?php echo htmlspecialchars($contact['functie'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($contact['telefon'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($contact['email'] ?? ''); ?></td>
                            <td class="text-end">
                                <form action="contact_sterge.php" method="post" class="d-inline"
                                    onsubmit="return confirm('Sigur ștergi această persoană de contact?');">
                                    <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Șterge</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
  
    </form>
 
</div>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
