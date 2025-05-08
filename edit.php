<?php
session_start();

// Логин шалгах
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] != true) {
    header("Location: login.php");
    exit();
}

// MySQL холболт
$host = "localhost";
$user = "root";
$password = "";
$dbname = "portfolio_db"; // Өгөгдлийн сангийн нэр
$conn = new mysqli($host, $user, $password, $dbname);

// Хэрэв холболт амжилттай бол
if ($conn->connect_error) {
    die("Холболт амжилтгүй: " . $conn->connect_error);
}

// Зураг болон файл оруулах
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Танилцуулга шинэчлэх
    if (isset($_POST['about_description'])) {
        $description = $_POST['about_description'];
        $sql = "UPDATE about SET description=? WHERE id=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $description);
        $stmt->execute();
        echo "<p>Танилцуулга амжилттай шинэчлэгдлээ!</p>";
    }

    // Холбоо барих мэдээлэл шинэчлэх
    if (isset($_POST['email']) && isset($_POST['phone'])) {
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sql = "UPDATE contact SET email=?, phone=? WHERE id=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        echo "<p>Холбоо барих мэдээлэл амжилттай шинэчлэгдлээ!</p>";
    }

    // Амжилт шинэчлэх
    if (isset($_POST['achievement_title'])) {
        $title = $_POST['achievement_title'];
        $sql = "INSERT INTO achievements (title) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        echo "<p>Амжилт амжилттай нэмэгдлээ!</p>";
    }

    // Бүтээлийн зураг болон файл оруулах
    if (isset($_FILES['project_image']) && isset($_POST['project_title']) && isset($_FILES['project_file']) && isset($_POST['project_description'])) {
        $project_title = $_POST['project_title'];
        $project_description = $_POST['project_description'];

        // Зураг оруулах
        $file_name = $_FILES['project_image']['name'];
        $file_tmp = $_FILES['project_image']['tmp_name'];
        $upload_dir = "../uploads/";
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $valid_ext = array("jpg", "jpeg", "png", "gif");

        if (in_array($file_ext, $valid_ext)) {
            $new_file_name = "project_image_" . time() . "." . $file_ext;
            move_uploaded_file($file_tmp, $upload_dir . $new_file_name);
        } else {
            echo "<p class='error'>Зураг зөв форматаар байх ёстой.</p>";
        }

        // Бүтээлийн файл оруулах
        $file_name_project = $_FILES['project_file']['name'];
        $file_tmp_project = $_FILES['project_file']['tmp_name'];
        $upload_dir_project = "../uploads/";
        $file_ext_project = strtolower(pathinfo($file_name_project, PATHINFO_EXTENSION));
        $valid_ext_project = array("pdf", "docx", "zip");

        if (in_array($file_ext_project, $valid_ext_project)) {
            $new_file_name_project = "project_file_" . time() . "." . $file_ext_project;
            move_uploaded_file($file_tmp_project, $upload_dir_project . $new_file_name_project);
        } else {
            echo "<p class='error'>Файл зөв форматаар байх ёстой.</p>";
        }

        // Бүтээлийн мэдээллийг өгөгдлийн санд оруулах
        $sql_project = "INSERT INTO projects (title, description, image, file) VALUES (?, ?, ?, ?)";
        $stmt_project = $conn->prepare($sql_project);
        $stmt_project->bind_param("ssss", $project_title, $project_description, $new_file_name, $new_file_name_project);
        $stmt_project->execute();
        echo "<p>Бүтээл амжилттай нэмэгдлээ!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Засах</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Мэдээлэл Засах</h2>

        <!-- Танилцуулга засах -->
        <form method="POST">
            <textarea name="about_description" placeholder="Танилцуулга" required></textarea>
            <button type="submit" class="btn">Танилцуулга шинэчлэх</button>
        </form>

        <!-- Холбоо барих засах -->
        <form method="POST">
            <input type="email" name="email" placeholder="Имэйл" required>
            <input type="text" name="phone" placeholder="Утасны дугаар" required>
            <button type="submit" class="btn">Холбоо барих мэдээлэл шинэчлэх</button>
        </form>

        <!-- Амжилт нэмэх -->
        <form method="POST">
            <input type="text" name="achievement_title" placeholder="Амжилт" required>
            <button type="submit" class="btn">Амжилт нэмэх</button>
        </form>

        <!-- Бүтээл нэмэх -->
        <h3>Бүтээл нэмэх</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="project_title" placeholder="Бүтээлийн нэр" required>
            <textarea name="project_description" placeholder="Бүтээлийн тайлбар" required></textarea>
            <input type="file" name="project_image" required>
            <input type="file" name="project_file" required>
            <button type="submit" class="btn">Бүтээл нэмэх</button>
        </form>
    </div>
</body>
</html>
