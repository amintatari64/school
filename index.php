<?php
session_start();
if (isset($_GET['logout'])) {
  unset($_SESSION['ok']);
  unset($_SESSION['code']);
  unset($_SESSION['access']);
  unset($_SESSION['fname']);
  unset($_SESSION['lname']);
  session_destroy();
}
if (isset($_SESSION['ok'])) {
} else {
?>
  <script>
    window.location = 'indexsite.php';
  </script>
<?php
}
if (!isset($_GET['usercontrol']) and !isset($_GET['controlscore']) and !isset($_GET['news']) and !isset($_GET['message']) and !isset($_GET['showscore'])) {
  if ($_SESSION['access'] == "student") {
    echo "<script> window.location = 'index.php?showscore=1' </script>";
  } elseif ($_SESSION['access'] == "teacher") {
    echo "<script> window.location = 'index.php?controlscore=1' </script>";
  } else {
    echo "<script> window.location = 'index.php?usercontrol=1' </script>";
  }
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
  <title>صفحه اصلی</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
  <!--style-->
  <link rel="stylesheet" href="css/font.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/clock.css">
  <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <nav class="navbar navbar-expand-lg p-2 py-3 shadow-sm navbar-light bg-light">
    <div class="container-fluid">
      <span class="clock me-lg-4" style="direction: ltr;"></span>
      <a class="navbar-brand"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="indexsite.php">صفحه اصلی</a>
          </li>
          <?php
          if ($_SESSION['access'] == "admin") { ?>
            <li class="nav-item">
              <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?usercontrol=1">مدیریت کاربران</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?controlscore=1">مدیریت نمرات</a>
            </li>
          <?php }
          if ($_SESSION['access'] == "teacher") {
          ?>
            <li class="nav-item">
              <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?controlscore=1">مدیریت نمرات</a>
            </li>
          <?php } ?>
          <?php
          if ($_SESSION['access'] == "student") {
          ?>
            <li class="nav-item">
              <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?showscore=1">نمایش نمرات</a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?news=1">تابلو اعلانات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn-outline-success p-2 px-3 mx-1 border-success rounded color-white" href="index.php?message=1">مدیریت پیام ها</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn-outline-danger p-2 px-3 mx-1 border-danger rounded color-white" href="index.php?logout=1">خروج</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <?php
  if (isset($_GET['usercontrol'])) {
  ?>
    <iframe src="admin/usercontrol.php" style="width: 100vw;height:90vh;" frameborder="0"></iframe>
  <?php
  }
  if (isset($_GET['controlscore'])) {
  ?>
    <iframe src="teacher/usercontrol.php" style="width: 100vw;height:90vh;" frameborder="0"></iframe>
  <?php
  }
  if (isset($_GET['news'])) {
  ?>
    <iframe src="news/access.php" style="width: 100vw;height:90vh;" frameborder="0"></iframe>
  <?php
  }
  if (isset($_GET['message'])) {
  ?>
    <iframe src="message/index.php" style="width: 100vw;height:90vh;" frameborder="0"></iframe>
  <?php
  }
  if (isset($_GET['showscore'])) {
  ?>
    <iframe src="student/show_score.php" style="width: 100vw;height:90vh;" frameborder="0"></iframe>
  <?php
  }?>
  <script src="js/clock.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>