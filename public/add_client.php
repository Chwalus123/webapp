<?php
require_once __DIR__ . '/../config/db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName     = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $company  = trim($_POST['company']);
    $phoneRaw = $_POST['phone'];
    $phone    = preg_replace('/\D/', '', $phoneRaw);

    if (!$firstName || !$lastName || !$company || !preg_match('/^[0-9]{9}$/', $phone)) {
        $msg = 'Uzupełnij wszystkie pola poprawnie (9 cyfr).';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO clients (firstName, lastName, company, phone) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$firstName, $lastName, $company, $phone]);
        $msg = 'Klient dodany pomyślnie!';
    }
}
include 'header.php';
?>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-3 border border-2 border-dark rounded-3 p-4">
            <h2 class="text-center">Dodaj klienta</h2>

            <?php if ($msg): ?>
                <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form class="mt-3 text-center" method="post">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Imię</label>
                    <input id="firstName" name="firstName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Nazwisko</label>
                    <input id="lastName" name="lastName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="company" class="form-label">Nazwa firmy</label>
                    <input id="company" name="company" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Numer telefonu</label>
                    <input id="phone" name="phone" class="form-control"
                        pattern="\d{9}" title="Wprowadź 9 cyfr, np. 123456789" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Zapisz</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>