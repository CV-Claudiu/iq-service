    <h2 class="h4 mt-5">Echipamente (<?php echo count($echipamente); ?>)</h2>
 
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
