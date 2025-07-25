<?php
require_once __DIR__ . '/../config/db.php';
$sql = "
  SELECT c.id, c.firstName, c.lastName, c.company, c.phone,
         GROUP_CONCAT(e.firstName, ' ', e.lastName SEPARATOR ', ') AS carers
  FROM clients c
  LEFT JOIN client_employee ce ON ce.client_id = c.id
  LEFT JOIN employees e ON e.id = ce.employee_id
  GROUP BY c.id
  ORDER BY c.id
";
$rows = $pdo->query($sql)->fetchAll();
include 'header.php';
?>
<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 border border-2 border-dark rounded-3 p-4">
            <h2 class="mt-4 text-center">Lista klientów</h2>
            <table class="mt-4 table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Klient</th>
                        <th>Firma</th>
                        <th>Telefon</th>
                        <th>Opiekunowie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= htmlspecialchars($r['firstName'] . ' ' . $r['lastName']) ?></td>
                            <td><?= htmlspecialchars($r['company']) ?></td>
                            <td><?= htmlspecialchars($r['phone']) ?></td>
                            <td><?= htmlspecialchars($r['carers'] ?: '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>