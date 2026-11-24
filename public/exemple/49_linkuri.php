<?php
//exemplul 49 - linkuri care pastreaza filtrele din URL
$filtre = [
    'status'=> $_GET['status'] ?? '',
    'prioritate'=> $_GET['prioritate'] ?? '',
];

?>
<DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 49 - Linkuri cu Filtre</title>
</head>
<body>
    <h1>Filtre:<?php echo htmlspecialchars(implode(', ',$filtre)); ?></h1>
    <?php
</body>
</html>
