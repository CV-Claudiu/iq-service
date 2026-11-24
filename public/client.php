<?php
// IQ SERVICE - fișa clientului (Ziua 7, completată în zilele 10, 13, 17 și 20)
// Afișează toate datele unui client: echipamente, persoane de contact și activități

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/init.php'; // Încarcă funcțiile de configurare, citește .env și deschide conexiunea la baza de date.

$id = (int) ($_GET['id'] ?? 0);

// 1. ÎNTÂI clientul: dacă nu există, oprim pagina aici
$comanda = $pdo->prepare('SELECT * FROM clienti WHERE id = :id and activ = 1');
$comanda->execute(['id' => $id]);
$client = $comanda->fetch();

if (!$client) {
    echo 'Clientul nu există. <a href="clienti.php">Înapoi la listă</a>';
    exit;
}

// 2. Persoanele de contact ale clientului (Ziua 10) - ACEST BLOC LIPSEA
$comanda = $pdo->prepare('SELECT * FROM contacte WHERE client_id = :id ORDER BY nume');
$comanda->execute(['id' => $id]);
$contacte = $comanda->fetchAll();

// 3. Echipamentele clientului (Ziua 13)
$comanda = $pdo->prepare('select echipamente.denumire,echipamente.serie,categorii.denumire as categorie ,echipamente.data_instalare from echipamente
join categorii on categorii.id=echipamente.categorie_id
where echipamente.client_id=:id order by 1 ASC');
$comanda->execute(['id' => $id]);
$echipamente = $comanda->fetchAll();

// 4. Mesajele de confirmare (zilele 11, 13 și 20)
$mesaje = [
    'adaugat' => 'Persoana de contact a fost adaugată!',
    'sters' => 'Persoana de contact a fost ștearsă!'
];
$mesaj = $mesaje[$_GET['contact'] ?? ''] ?? '';

if (($_GET['echipament'] ?? '') === 'adaugat') {
    $mesaj = 'Echipamentul a fost adăugat!';
}

if (($_GET['activitate'] ?? '') === 'adaugata') {
    $mesaj = 'Activitatea a fost adăugată.';
}

// 5. Activitățile clientului (Ziua 20)
$comanda = $pdo->prepare('SELECT activitati.*, utilizatori.nume AS utilizator
                          FROM activitati
                          JOIN utilizatori ON utilizatori.id = activitati.utilizator_id
                          WHERE activitati.client_id = :id
                          ORDER BY activitati.data_activitate DESC');
$comanda->execute(['id' => $id]);
$activitati = $comanda->fetchAll();

// Titlul paginii, folosit de antet
$titlu = $client['denumire'];
?>
<?php require BASE_PATH . '/app/View/antet.php'; ?>
<div style="max-width: 700px;">

<?php if ($mesaj !== ''): ?>
    <div class="alert alert-success">
        <p><?php echo $mesaj; ?></p>
    </div>
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

    <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
    <a href="clienti.php" class="btn btn-secondary">
        Înapoi la listă
    </a>

    <?php if (areRol(['administrator', 'operator'])): ?>
        <a href="client_editeaza.php?id=<?php echo (int) $client['id']; ?>"
           class="btn btn-primary">
            Modifică
        </a>

        <form action="client_dezactiveaza.php"
              method="post"
              style="margin: 0;"
              onsubmit="return confirm('Sigur dezactivezi acest client?');">
            <input type="hidden"
                   name="id"
                   value="<?php echo (int) $client['id']; ?>">

            <button type="submit" class="btn btn-danger">
                Dezactivează
            </button>
        </form>

        <a href="solicitare_adauga.php?client_id=<?php echo (int) $client['id']; ?>"
           class="btn btn-warning">
            Solicitare nouă
        </a>
    <?php endif; ?>
</div>

    <a href="activitate_adauga.php?client_id=<?php echo $client['id']; ?>" class="btn btn-outline-primary">Activitate nouă</a>

    <h2 class="h4 mt-5">Echipamente (<?php echo count($echipamente); ?>)</h2>

    <?php if (areRol(['administrator','operator'])): ?>
    <a href="echipament_adauga.php?client_id=<?php echo $client['id']; ?>" class="btn btn-success mb-3">Adaugă echipament</a>
    <?php endif; ?>

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

    <!-- Titlul secțiunii de contacte - ACEST RÂND LIPSEA -->
    <h2 class="h4 mt-5">Persoane de contact (<?php echo count($contacte); ?>)</h2>

<?php if (areRol(['administrator','operator'])): ?>
    <a href="contact_adauga.php?client_id=<?php echo $client['id']; ?>" class="btn btn-primary mb-3">Adaugă persoană de contact</a>
<?php endif; ?>

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
                            <?php if (areRol(['administrator','operator'])): ?>
                            <form action="contact_sterge.php" method="post" class="d-inline"
                                  onsubmit="return confirm('Sigur ștergi această persoană de contact?');">
                                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Șterge</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2 class="h4 mt-5">Activități (<?php echo count($activitati); ?>)</h2>

    <?php if (count($activitati) === 0): ?>
        <p class="text-muted">Nicio activitate încă.</p>
    <?php else: ?>
        <ul class="list-group mb-4">
            <?php foreach ($activitati as $activitate): ?>
                <li class="list-group-item">
                    <div class="small text-muted">
                        <?php echo date('d.m.Y H:i', strtotime($activitate['data_activitate'])); ?>,
                        <?php echo htmlspecialchars($activitate['utilizator']); ?>,
                        <?php echo $tipuriActivitate[$activitate['tip']]; ?>
                        <?php echo durata($activitate['durata_minute']); ?>
                        <?php if ($activitate['solicitare_id'] !== null): ?>
                            , <a href="solicitare.php?id=<?php echo $activitate['solicitare_id']; ?>">solicitarea nr. <?php echo $activitate['solicitare_id']; ?></a>
                        <?php endif; ?>
                    </div>
                    <div><?php echo nl2br(htmlspecialchars($activitate['descriere'])); ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/View/subsol.php'; ?>