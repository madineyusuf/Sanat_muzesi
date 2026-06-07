<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Arama ve filtre
$tur    = $_GET['tur'] ?? '';
$arama  = $_GET['arama'] ?? '';

$sql    = "SELECT * FROM eserler WHERE 1=1";
$params = [];

if ($tur) {
    $sql .= " AND tur = ?";
    $params[] = $tur;
}
if ($arama) {
    $sql .= " AND (eser_adi LIKE ? OR sanatci LIKE ?)";
    $params[] = "%$arama%";
    $params[] = "%$arama%";
}
$sql .= " ORDER BY eklenme_tarihi DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$eserler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kullanıcının favorileri
$favori_ids = [];
if (isLoggedIn()) {
    $fav = $pdo->prepare("SELECT eser_id FROM favoriler WHERE kullanici_id = ?");
    $fav->execute([$_SESSION['kullanici_id']]);
    $favori_ids = $fav->fetchAll(PDO::FETCH_COLUMN);
}

// Kategoriler
$turler = $pdo->query("SELECT DISTINCT tur FROM eserler ORDER BY tur")->fetchAll(PDO::FETCH_COLUMN);
?>
<?php require_once 'includes/header.php'; ?>

<div class="container mt-4">

    <!-- Başlık -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">🎨 Sanat Müzesi</h1>
        <p class="text-muted">Dünyanın en ünlü eserlerini keşfedin</p>
    </div>

    <!-- Arama & Filtre -->
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-6">
            <input type="text" name="arama" class="form-control"
                   placeholder="Eser adı veya sanatçı..."
                   value="<?= htmlspecialchars($arama) ?>">
        </div>
        <div class="col-md-4">
            <select name="tur" class="form-select">
                <option value="">Tüm Kategoriler</option>
                <?php foreach ($turler as $t): ?>
                    <option value="<?= htmlspecialchars($t) ?>"
                        <?= $tur === $t ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Ara</button>
        </div>
    </form>

    <!-- Eser Kartları -->
    <?php if (empty($eserler)): ?>
        <div class="text-center text-muted mt-5">
            <i class="bi bi-search fs-1"></i>
            <p class="mt-2">Eser bulunamadı.</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($eserler as $eser): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="artwork.php?id=<?= $eser['id'] ?>">
                        <img src="<?= htmlspecialchars($eser['gorsel_yolu'] ?? 'assets/images/placeholder.jpg') ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($eser['eser_adi']) ?>"
                             style="height: 220px; object-fit: cover;">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($eser['eser_adi']) ?></h5>
                        <p class="card-text text-muted">
                            <?= htmlspecialchars($eser['sanatci']) ?> · <?= htmlspecialchars($eser['yil']) ?>
                        </p>
                        <span class="badge bg-secondary"><?= htmlspecialchars($eser['tur']) ?></span>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="artwork.php?id=<?= $eser['id'] ?>" class="btn btn-sm btn-outline-primary">
                            İncele
                        </a>
                        <?php if (isLoggedIn()): ?>
                            <button class="btn btn-sm fav-btn <?= in_array($eser['id'], $favori_ids) ? 'btn-danger' : 'btn-outline-danger' ?>"
                                    data-id="<?= $eser['id'] ?>">
                                <i class="bi bi-heart<?= in_array($eser['id'], $favori_ids) ? '-fill' : '' ?>"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

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
        if (data.status === 'added') {
            btn.classList.replace('btn-outline-danger', 'btn-danger');
            icon.classList.replace('bi-heart', 'bi-heart-fill');
        } else {
            btn.classList.replace('btn-danger', 'btn-outline-danger');
            icon.classList.replace('bi-heart-fill', 'bi-heart');
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
