<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { color: navy; }
    </style>
</head>
<body>
    <h1>Facture</h1>
    <p><strong>Client :</strong> <?= esc($client) ?></p>
    <p><strong>Date :</strong> <?= esc($date) ?></p>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix unitaire (€)</th>
                <th>Total (€)</th>
            </tr>
        </thead>
        <tbody>
        <?php $total = 0; ?>
        <?php foreach ($items as $item): ?>
            <?php $sousTotal = $item['quantite'] * $item['prix']; ?>
            <tr>
                <td><?= esc($item['description']) ?></td>
                <td><?= esc($item['quantite']) ?></td>
                <td><?= esc(number_format($item['prix'], 2)) ?></td>
                <td><?= esc(number_format($sousTotal, 2)) ?></td>
            </tr>
            <?php $total += $sousTotal; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?= esc(number_format($total, 2)) ?> €</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
