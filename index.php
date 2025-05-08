<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile Website</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

  <header>
    <a href="#" class="logo">ЛОГО</a>
    <nav class="navbar">
      <a href="#">Нүүр</a>
      <a href="#about">Миний тухай</a>
      <a href="#achievements">Амжилт</a>
      <a href="#contact">Холбоо барих</a>
    </nav>
  </header>

  <!-- Home -->
  <section class="home">
    <div class="home-detail">
      <h1>Ариунзаяа</h1>
      <h2>IT Student</h2>
      <p>Миний хувийн веб хуудсанд тавтай морил!</p>
    </div>
  </section>

  <!-- About -->
  <section class="about" id="about">
    <div class="about-text">
      <h2>About <span>me</span></h2>
      <?php
      $result = $conn->query("SELECT * FROM about LIMIT 1");
      $about = $result->fetch_assoc();
      echo "<p>" . $about['description'] . "</p>";
      ?>
    </div>
  </section>

  <!-- Achievements -->
  <section class="achievements" id="achievements">
    <h2>Амжилт</h2>
    <ul>
      <?php
      $result = $conn->query("SELECT * FROM achievements");
      while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['title'] . "</li>";
      }
      ?>
    </ul>
  </section>

  <div class="projects-container">
        <h1>Миний Бүтээлүүд</h1>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="project">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <img src="uploads/<?php echo $row['image']; ?>" alt="Бүтээл">
                <a href="uploads/<?php echo $row['file']; ?>" target="_blank">Файлыг татаж авах</a>
            </div>
        <?php } ?>
    </div>
  <!-- Contact -->
  <section class="contact" id="contact">
    <h2>Холбоо барих</h2>
    <?php
    $result = $conn->query("SELECT * FROM contact LIMIT 1");
    $contact = $result->fetch_assoc();
    ?>
    <p>📧 Email: <?= $contact['email']; ?></p>
    <p>📱 Утас: <?= $contact['phone']; ?></p>
  </section>

</div>


</body>
</html>
