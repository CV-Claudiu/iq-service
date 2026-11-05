<?php
// Exemplul 24 - o listă derulantă construită din PHP
// Alegerea rămâne bifată și după ce apăsăm Trimite.
 
$prioritati = [
    1 => 'Mică',
    2 => 'Normală',
    3 => 'Urgentă',
];
 
$aleasa = (int) ($_POST['prioritate'] ?? 0);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 24 - listă derulantă</title>
</head>
<body>
    <form method="post">
        <select name="prioritate">
            <option value="">- alege -</option>
            <?php foreach ($prioritati as $numar => $text): ?>
                <option value="<?php echo $numar; ?>" <?php echo $numar === $aleasa ? 'selected' : ''; ?>><?php echo $text; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Trimite</button>
    </form>
 
    <?php if (isset($prioritati[$aleasa])): ?>
        <p>Ai ales: <?php echo $prioritati[$aleasa]; ?> (numărul <?php echo $aleasa; ?>)</p>
    <?php endif; ?>
</body>
</html>
