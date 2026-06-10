<?php
// 1. Her session işleminden önce oturumu başlatmak zorundayız
session_start();

// 2. Oturuma ait tüm değişkenleri temizliyoruz
$_SESSION = array();

// 3. Eğer tarayıcıda oturuma ait bir çerez (cookie) varsa onu da siliyoruz (Güvenlik için)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Sunucudaki oturumu tamamen yok ediyoruz
session_destroy();

// 5. Kullanıcıyı güvenli bir şekilde kayıt veya giriş sayfasına yönlendiriyoruz
header("Location: kayit.php");
exit;
?>
