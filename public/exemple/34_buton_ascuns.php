<?php
// Exemplul 34 - un buton care apare doar pentru unii
// Încearcă: 34_buton_ascuns.php?rol=operator, apoi ?rol=agent
 
$rolulMeu = $_GET['rol'] ?? 'agent';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 34 - buton ascuns</title>
</head>
<body>
    <h1>Fișa clientului Termoplast Service</h1>
    <p>Rolul meu: <?php echo htmlspecialchars($rolulMeu); ?></p>
 
    <?php if (in_array($rolulMeu, ['administrator', 'operator'])): ?>
        <button>Modifică</button>
    <?php endif; ?>
 
</body>
</html>
