<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = trim($_POST['kullanici_adi'] ?? '');
    $sifre         = $_POST['sifre'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->execute([$kullanici_adi]);
    $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($kullanici && password_verify($sifre, $kullanici['sifre_hash'])) {
        $_SESSION['kullanici_id']  = $kullanici['id'];
        $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
        header('Location: /~st24360859922/index.php');
        exit;
    } else {
        $error = 'Kullanıcı adı veya şifre hatalı.';
    }
}
?>
<?php require_once 'includes/header.php'; ?>

<main class="flex-grow-1 d-flex align-items-center">
    <div class="container" style="max-width: 450px">
        <h2 class="mb-4">Giriş Yap</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Kullanıcı Adı</label>
                <input type="text" name="kullanici_adi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Şifre</label>
                <input type="password" name="sifre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
        </form>

        <p class="mt-3 text-center">Hesabın yok mu? <a href="/~st24360859922/register.php">Kayıt ol</a></p>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
