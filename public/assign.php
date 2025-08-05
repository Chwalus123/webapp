<?php
require_once __DIR__ . '/../config/db.php';
$msg = '';
$clients   = $pdo->query("SELECT id, firstName, lastName FROM clients ORDER BY firstName")->fetchAll();
$employees = $pdo->query("SELECT id, firstName, lastName FROM employees ORDER BY firstName")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = (int)($_POST['client_id'] ?? 0);
    $emp_ids   = $_POST['employee_ids'] ?? [];

    if ($client_id > 0 && count($emp_ids)) {
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO client_employee (client_id, employee_id)
            VALUES (?, ?)
        ");
        foreach ($emp_ids as $eid) {
            $stmt->execute([$client_id, (int)$eid]);
        }
        $msg = 'Nowi opiekunowie zostali przypisani.';
    } else {
        $msg = 'Wybierz klienta i co najmniej jednego opiekuna.';
    }
}
include 'header.php';
?>
<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-xl-3 col-l-4 col-md-6 border border-2 border-dark rounded-3 p-4">
            <h2 class="text-center">Przypisz opiekuna</h2>
            <?php if ($msg): ?>
                <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
            <form class="mt-3 text-center" method="post">
                <div class="mb-3">
                    <label>Klient</label>
                    <select name="client_id" class="form-select" required>
                        <option value="">— wybierz —</option>
                        <?php foreach ($clients as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['firstName'] . ' ' . $c['lastName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Opiekunowie (Ctrl + klik, aby zaznaczyć wielu opiekunów)</label>
                    <select name="employee_ids[]" class="form-select" multiple size="5" required>
                        <?php foreach ($employees as $e): ?>
                            <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['firstName'] . ' ' . $e['lastName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>