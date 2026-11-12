<?php
// Exemplul 33 - cine ce are voie să facă
// Încearcă: 33_roluri.php?rol=administrator, ?rol=operator, ?rol=agent
 
$rolulMeu = $_GET['rol'] ?? 'agent';
 
function arePermisiune($rol, $roluriPermise)
{
    return in_array($rol, $roluriPermise);
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 33 - roluri</title>
</head>
<body>
    <h1>Rolul meu: <?php echo htmlspecialchars($rolulMeu); ?></h1>
    <ul>
        <li>Vede clienții: <?php echo arePermisiune($rolulMeu, ['administrator', 'operator', 'agent']) ? 'da' : 'nu'; ?></li>
        <li>Adaugă clienți: <?php echo arePermisiune($rolulMeu, ['administrator', 'operator']) ? 'da' : 'nu'; ?></li>
        <li>Adaugă utilizatori: <?php echo arePermisiune($rolulMeu, ['administrator']) ? 'da' : 'nu'; ?></li>
    </ul>
    <p>
        <a href="33_roluri.php?rol=administrator">administrator</a> |
        <a href="33_roluri.php?rol=operator">operator</a> |
        <a href="33_roluri.php?rol=agent">agent</a>
    </p>
</body>
</html>
