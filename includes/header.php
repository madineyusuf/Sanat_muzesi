<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sanat Müzesi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/index.php"> Sanat Müzesi</a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <?php if (isLoggedIn()): ?>
                <a href="/profile.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['kullanici_adi']) ?>
                </a>
                <a href="/logout.php" class="btn btn-outline-danger btn-sm">Çıkış</a>
            <?php else: ?>
                <a href="/login.php" class="btn btn-outline-light btn-sm">Giriş</a>
                <a href="/register.php" class="btn btn-light btn-sm">Kayıt Ol</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
