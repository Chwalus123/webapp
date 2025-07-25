<?php
require_once __DIR__ . '/../config/db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    if ($firstName && $lastName) {
        $stmt = $pdo->prepare("INSERT INTO employees (firstName, lastName) VALUES (?, ?)");
        $stmt->execute([$firstName, $lastName]);
        $msg = 'Opiekun dodany!';
    }
}
include 'header.php';
?>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-3 border border-2 border-dark rounded-3 p-4">
            <h2 class="text-center">Dodaj opiekuna</h2>
            <?php if ($msg): ?>
                <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
            <form class="mt-3 text-center" method="post">
                <div class="mb-3">
                    <label>Imię</label>
                    <input name="firstName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nazwisko</label>
                    <input name="lastName" class="form-control" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>