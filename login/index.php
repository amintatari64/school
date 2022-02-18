<?php include("config.php");
?>
<html lang="fa" dir="rtl">

<head>
  <title>ورود</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
  <!--style-->
  <link rel="stylesheet" href="../css/font.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="shortcut icon" href="../favicon.ico">
</head>

<body>

  <body>
    <div class="container-sm mt-5 d-flex justify-content-center flex-column align-items-center">
      <div class="mt-3 d-flex justify-content-center">
        <form action="" method="post">
          <input type="text" class="form-control" name="uname" placeholder="نام کاربری..." aria-label="Username"><br>
          <input type="password" class="form-control" name="password" placeholder="رمز عبور..." aria-label="Server">
      </div>
      <div>
        <button type="submit" id="btn_submit" name="submit_login" class="mt-3 border rounded bg-primary bg-opacity-75 px-5 p-2 text-white ms-1">ورود</button>
        <a class="mt-3 border border-primary rounded text-primary p-2 py-1 px-2 ms-1 text-decoration-none" id="back_link" href="../indexsite.php">صفحه اصلی سایت</a>
      </div>
      <?php include("errors.php"); ?>
      </form>
    </div>
    <p class="m-3">کاربر پیشفرض مدیر </p>
    <p class="m-3">نام کاربری و رمز عبور = 987654321</p><br>
    <p class="m-3">کاربر پیشفرض معلم </p>
    <p class="m-3">123456789 = نام کاربری و رمز عبور</p><br>
    <p class="m-3">کاربر پیشفرض دانش آموز </p>
    <p class="m-3">نام کاربری و رمز عبور = 1234567890</p><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>

</html>