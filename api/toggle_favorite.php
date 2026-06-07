<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['error' => 'Giriş gerekli']);
    exit;
}

$eser_id      = (int)($_POST['eser_id'] ?? 0);
$kullanici_id = $_SESSION['kullanici_id'];

if (!$eser_id) {
    echo json_encode(['error' => 'Geçersiz eser']);
    exit;
}

$kontrol = $pdo->prepare("SELECT id FROM favoriler WHERE kullanici_id = ? AND eser_id = ?");
$kontrol->execute([$kullanici_id, $eser_id]);

if ($kontrol->fetch()) {
    $pdo->prepare("DELETE FROM favoriler WHERE kullanici_id = ? AND eser_id = ?")
        ->execute([$kullanici_id, $eser_id]);
    echo json_encode(['status' => 'removed']);
} else {
    $pdo->prepare("INSERT INTO favoriler (kullanici_id, eser_id) VALUES (?, ?)")
        ->execute([$kullanici_id, $eser_id]);
    echo json_encode(['status' => 'added']);
}
