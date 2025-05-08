<?php
session_start();

// Логин шалгах
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Админ логин мэдээллийг шалгах (энэ жишээ нь хатуу кодлогдсон)
    $admin_username = "admin";
    $admin_password = "password"; // Энэ нь энгийн туршилтын хувилбар.
    
    if ($_POST['username'] == $admin_username && $_POST['password'] == $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php"); // Нэвтэрсэн бол админ самбарт орох
    } else {
        $error_message = "Нэвтрэх мэдээлэл буруу байна!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="login-form">
        <h2>Админ Нэвтрэх</h2>
        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Нэвтрэх нэр" required>
            <input type="password" name="password" placeholder="Нууц үг" required>
            <button type="submit">Нэвтрэх</button>
        </form>
    </div>
</body>
</html>
