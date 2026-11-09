<?php
// IQ SERVICE - lista utilizatorilor aplicației (Ziua 14)
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$utilizatori = $pdo->query('SELECT id, nume, email, rol, activ FROM utilizatori ORDER BY nume')->fetchAll();
 
// Titlul paginii, folosit de antet
$titlu = 'Utilizatori';
?>
<?php require BASE_PATH . '/app/Views/antet.php'; ?>
 
    <h1>Utilizatori</h1>
 
    <?php if (isset($_GET['adaugat'])): ?>
        <div class="alert alert-success">Utilizatorul a fost adăugat.</div>
    <?php endif; ?>
 
    <p><a href="utilizator_adauga.php" class="btn btn-success">Adaugă utilizator</a></p>
 
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nume</th>
                <th>E-mail</th>
                <th>Rol</th>
                <th>Stare</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilizatori as $utilizator): ?>
                <tr>
                    <td><?php echo htmlspecialchars($utilizator['nume']); ?></td>
                    <td><?php echo htmlspecialchars($utilizator['email']); ?></td>
                    <td><?php echo $utilizator['rol']; ?></td>
                    <td><?php echo $utilizator['activ'] ? 'activ' : 'inactiv'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
<?php require BASE_PATH . '/app/Views/subsol.php'; ?>
