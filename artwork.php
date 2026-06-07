<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM eserler WHERE id = ?");
$stmt->execute([$id]);
$eser = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$eser) {
    header('Location: index.php');
    exit;
}

// Yorum gönderme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $icerik = trim($_POST['icerik'] ?? '');
    if ($icerik) {
        $ins = $pdo->prepare("INSERT INTO yorumlar (kullanici_id, eser_id, icerik) VALUES (?, ?, ?)");
        $ins->execute([$_SESSION['kullanici_id'], $id, $icerik]);
        header("Location: artwork.php?id=$id");
        exit;
    }
}

// Yorumları çek
$stmt2 = $pdo->prepare("
    SELECT y.*, k.kullanici_adi
    FROM yorumlar y
    JOIN kullanicilar k ON k.id = y.kullanici_id
    WHERE y.eser_id = ?
    ORDER BY y.olusturma_tarihi DESC
");
$stmt2->execute([$id]);
$yorumlar = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Favori durumu
$favori = false;
if (isLoggedIn()) {
    $f = $pdo->prepare("SELECT id FROM favoriler WHERE kullanici_id = ? AND eser_id = ?");
    $f->execute([$_SESSION['kullanici_id'], $id]);
    $favori = (bool)$f->fetch();
}
?>
<?php require_once 'includes/header.php'; ?>

<div class="container mt-4">

    <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Geri Dön
    </a>

    <div class="row">
        <!-- Görsel -->
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($eser['gorsel_yolu'] ?? 'assets/images/placeholder.jpg') ?>"
                 class="img-fluid rounded shadow" alt="<?= htmlspecialchars($eser['eser_adi']) ?>">
        </div>

        <!-- Bilgiler -->
        <div class="col-md-6">
            <h1 class="fw-bold"><?= htmlspecialchars($eser['eser_adi']) ?></h1>
            <p class="text-muted fs-5">
                <?= htmlspecialchars($eser['sanatci']) ?> · <?= htmlspecialchars($eser['yil']) ?>
            </p>
            <span class="badge bg-secondary mb-3"><?= htmlspecialchars($eser['tur']) ?></span>
            <p class="mt-3"><?= nl2br(htmlspecialchars($eser['aciklama'])) ?></p>

            <?php if (isLoggedIn()): ?>
                <button class="btn fav-btn <?= $favori ? 'btn-danger' : 'btn-outline-danger' ?>"
                        data-id="<?= $id ?>">
                    <i class="bi bi-heart<?= $favori ? '-fill' : '' ?>"></i>
                    <span><?= $favori ? 'Favorilerimde' : 'Favorilere Ekle' ?></span>
                </button>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-danger">
                    <i class="bi bi-heart"></i> Favorilere eklemek için giriş yapın
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Yorumlar -->
    <div class="mt-5">
        <button class="btn btn-outline-secondary mb-3" type="button"
                data-bs-toggle="collapse" data-bs-target="#yorumlar">
            <i class="bi bi-chat-dots"></i> Yorumlar (<?= count($yorumlar) ?>)
        </button>

        <div class="collapse" id="yorumlar">

            <?php if (isLoggedIn()): ?>
                <form method="POST" class="mb-4">
                    <div class="mb-2">
                        <textarea name="icerik" class="form-control" rows="3"
                                  placeholder="Yorumunuzu yazın..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Gönder</button>
                </form>
            <?php else: ?>
                <p class="text-muted">
                    <a href="login.php">Giriş yapın</a> ve yorum bırakın.
                </p>
            <?php endif; ?>

            <?php if (empty($yorumlar)): ?>
                <p class="text-muted">Henüz yorum yok. İlk yorumu siz yapın!</p>
            <?php endif; ?>

            <?php foreach ($yorumlar as $yorum): ?>
                <div class="card mb-2">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong><?= htmlspecialchars($yorum['kullanici_adi']) ?></strong>
                            <small class="text-muted"><?= $yorum['olusturma_tarihi'] ?></small>
                        </div>
                        <p class="mb-1 mt-1"><?= nl2br(htmlspecialchars($yorum['icerik'])) ?></p>
                        <?php if (isLoggedIn() && $_SESSION['kullanici_id'] == $yorum['kullanici_id']): ?>
                            <a href="api/delete_comment.php?id=<?= $yorum['id'] ?>&eser_id=<?= $id ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Yorumu silmek istediğinizden emin misiniz?')">
                                <i class="bi bi-trash"></i> Sil
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<script>
// Favori toggle
document.querySelectorAll('.fav-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        const res = await fetch('api/toggle_favorite.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `eser_id=${id}`
        });
        const data = await res.json();
        const icon = btn.querySelector('i');
        const span = btn.querySelector('span');
        if (data.status === 'added') {
            btn.classList.replace('btn-outline-danger', 'btn-danger');
            icon.classList.replace('bi-heart', 'bi-heart-fill');
            span.textContent = ' Favorilerimde';
        } else {
            btn.classList.replace('btn-danger', 'btn-outline-danger');
            icon.classList.replace('bi-heart-fill', 'bi-heart');
            span.textContent = ' Favorilere Ekle';
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
