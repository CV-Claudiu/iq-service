<?php
// IQ SERVICE - antetul comun al tuturor paginilor (Ziua 9)
// Pagina care îl include poate stabili înainte titlul, în variabila $titlu.
 
$titlu = isset($titlu) ? $titlu . ' - IQ SERVICE' : 'IQ SERVICE';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($titlu); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
 
<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">IQ SERVICE</a>
        <div class="navbar-nav">
            <a class="nav-link" href="index.php">Acasă</a>
            <a class="nav-link" href="clienti.php">Clienți</a>
            <a class="nav-link" href="contacte.php">Contacte</a>
            <a class="nav-link" href="echipamente.php">Echipamente</a>
            <a class="nav-link" href="categorii.php">Categorii</a>
            <a class="nav-link" href="servicii.php">Servicii</a>
            <?php if (areRol(['administrator'])): ?>
                <a class="nav-link" href="utilizatori.php">Utilizatori</a>
            <?php endif; ?>
            <?php if (areRol(['administrator', 'operator'])): ?>
                <a class="nav-link" href="client_adauga.php">Adaugă client</a>
            <?php endif; ?>
        </div>
         <div class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['utilizator'])): ?>
                <span class="navbar-text me-3"><?php echo htmlspecialchars($_SESSION['utilizator']['nume']); ?> (<?php echo $_SESSION['utilizator']['rol']; ?>)</span>
                <a class="nav-link" href="logout.php">Ieșire</a>
            <?php else: ?>
                <a class="nav-link" href="login.php">Intră în cont</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
 
<div class="container">
