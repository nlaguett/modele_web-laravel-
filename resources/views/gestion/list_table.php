<?php if (!empty($items)): ?>
  <table border="1" cellspacing="0">
    <thead>
      <tr>
        <?php foreach ($headers as $header): ?>
          <th><?= esc($header) ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <?php foreach ($item as $value): ?>
            <td><?= esc($value) ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>Aucun élément trouvé.</p>
<?php endif; ?>
