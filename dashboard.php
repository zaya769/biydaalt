<?php
session_start();

// Нэвтрэх шалгалт
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] != true) {
    header("Location: login.php"); // Нэвтрээгүй бол логинд буцааж очно.
    exit();
}

// Дараа нь энд мэдээллүүдийг харуулах, засах эсвэл устгах кодууд байж болно.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Админ Самбар</h2>
        <a href="edit.php" class="btn">Мэдээлэл засах</a>
        <a href="logout.php" class="btn">Гарах</a>

        <section class="info-section">
            <h3>Мэдээлэл</h3>
            <p>Энд таны мэдээллүүдийг засаж болох бөгөөд хэрвээ хүсвэл устгах боломжтой.</p>
        </section>
    </div>
</body>
</html>
