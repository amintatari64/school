<?php
session_start();
include "../db_info.php";
if (!isset($_SESSION['ok']) or $_SESSION['access'] == "student") {
?>
  <script>
    window.location = '../login/index.php';
  </script>
  <?php
}

$db = new mysqli($db_host, $db_username, $db_password, $users_db);
$db->set_charset("utf8");


$errors = array();
if (isset($_POST['score_send'])) {
  if (empty($_POST['code'])) {
    array_push($errors, "کد ملی را به درستی وارد کنید <br>");
  }
  if (empty($_POST['class'])) {
    array_push($errors, "شماره کلاس  را به درستی وارد کنید <br>");
  }
  if (empty($_POST['lesson'])) {
    array_push($errors, "نام درس  را به درستی وارد کنید <br>");
  }
  if (empty($_POST['score'])) {
    array_push($errors, "نمره  را به درستی وارد کنید <br>");
  }

  $code = mysqli_real_escape_string($db, $_POST['code']);
  $class = mysqli_real_escape_string($db, $_POST['class']);
  $lesson = mysqli_real_escape_string($db, $_POST['lesson']);
  $score = mysqli_real_escape_string($db, $_POST['score']);

  if (substr($code, 1) == 0) {
    $code = substr($code, 1);
  }
  $user_check_query = "SELECT * FROM info WHERE code='$code' LIMIT 1 ";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['code'] === $code and $user['access'] == "student") {
      if (count($errors) == 0) {
        $insert = "INSERT INTO score (code,class,lesson,score)
                VALUES ('$code','$class','$lesson','$score')";
        if ($db->query($insert) === TRUE) {
          $_SESSION['score'] = " نمره  " . $score . " درس " . $lesson . " برای دانش آموزش " . $user['fname'] . " " . $user['lname'] . " با موفقیت ثبت شد";
        } else {
          $_SESSION['score'] = " عملیات انجام نشد";
        }
      }
    } else {
      array_push($errors, "کاربری با این کد ملی یافت نشد <br>");
    }
  }
}
$btn_name = "show";
$btn_txt = "نمایش کاربران";
if (isset($_GET['show_user']) and isset($_GET['show'])) {
  $btn_txt = "پنهان کردن لیست کاربران";
  $class = $_GET['show_user'];

  if ($class == "all") {
    $n_sql = "";
  } else {
    $n_sql = "WHERE class='$class'";
  }
  $sql = "SELECT id,fname, lname, code,access,class FROM info " . $n_sql;
  $result = $db->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    function print_name()
    {
      global $result;
      while ($row = $result->fetch_assoc()) {
        if ($row['class'] != "000") {
          $_SESSION['url'] = $_SERVER['REQUEST_URI'];
  ?>
          <div class="col-lg-4 text-center">
            <p class="py-3 bg-success bg-opacity-75 rounded-3 shadow-sm">
              <?php echo $row['fname'] . " " . $row['lname'] . "<br>" . " کد ملی : " . $row['code'] . "<br> کلاس : " . $row['class']; ?><br>
              <a class="btn btn-info mt-4 m-2" href="<?php echo "show_user_score.php?code=" . $row['code'] . "&fname=" . $row['fname'] . "&lname=" . $row['lname'] . "&class=" . $row['class'] . "&show_user=1"; ?>">دیدن نمرات این دانش آموز</a><br>
          </div>
      <?php
        }
      }
    }
  } else {
    function empty_class()
    {
      ?>
      <div class="alert alert-danger alert-dismissible rounded-pill border p-3 fade show" role="alert">
        <strong class="fs-3 text-black">دانش آموزی در این کلاس وجود ندارد!</strong>
        <button type="button" class="btn-close fs-5 mt-2 me-2" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
<?php
    }
  }
  $btn_name = "hide";
} elseif (isset($_GET['hide'])) {
  echo "<script>window.location='usercontrol.php'</script>";
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
  <!--style-->
  <link rel="stylesheet" href="../css/font.css">
  <link rel="stylesheet" href="../css/usercontrol.css">
  <title>مدیریت کاربران </title>
</head>

<body>
  <div class="container-sm mt-5 text-center">
    <?php
    if (isset($_SESSION['score'])) {
    ?>
      <div class="alert alert-success alert-dismissible rounded-pill border p-3 fade show" role="alert">
        <strong class="fs-5 text-black"><?php echo $_SESSION['score']; ?></strong>
        <button type="button" class="btn-close ms-2 fs-5 me-2" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php
      unset($_SESSION['score']);
    }
    ?>

    <h1 class="border rounded mb-5 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">مدیریت نمرات دانش آموزان</h1>
    <form class="mb-5 p-2 bg-warning bg-opacity-10" action="" method="post">
      <div class="input-group mb-3 pt-5 px-lg-5">
        <div class="input-group mb-3 px-lg-5">
          <span class="input-group-text" id="basic-addon1">کد ملی دانش آموز</span>
          <input style="direction: rtl;" type="number" name="code" class="form-control" placeholder="کد ملی دانش آموز..." aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3 px-lg-5">
          <span class="input-group-text" id="basic-addon1">شماره کلاس دانش آموز</span>
          <input style="direction: rtl;" type="number" name="class" class="form-control" placeholder="شماره کلاس دانش آموز..." aria-label="Username" aria-describedby="basic-addon1">
        </div>
      </div>
      <div class="input-group mb-3 px-lg-5">
        <div class="input-group mb-3 px-lg-5">
          <span class="input-group-text" id="basic-addon1">نام درس</span>
          <input style="direction: rtl;" type="text" name="lesson" class="form-control" placeholder="نام درس..." aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3 px-lg-5">
          <span class="input-group-text" id="basic-addon1">نمره دانش آموز </span>
          <input style="direction: rtl;" type="number" name="score" class="form-control" placeholder="نمره دانش آموز..." aria-label="Username" aria-describedby="basic-addon1">
        </div>
      </div>
      <button type="submit" name="score_send" class="btn btn-outline-success mt-4 mb-4 p-2 fs-6">ثبت نمره</button>
    </form>
    <?php if (count($errors) > 0) : ?>
      <div class="mt-1 mb-5 p-2 pt-3 bg-danger text-white border rounded-pill shadow border-white d-flex flex-column align-items-center justify-content-center" style="color: red;">
        <?php foreach ($errors as $error) : ?>
          <p><?php echo $error ?></p>
        <?php endforeach ?>
      </div>
    <?php endif ?>

    <?php if ($btn_txt == "پنهان کردن لیست کاربران") {
      $d_none = "style='display:none;'";
    } else {
      $d_none = "";
    } ?>
    <form action="" method="get">
      <div <?php echo $d_none; ?> class="border rounded mt-5 mb-3 p-3 bg-info shadow-sm bg-opacity-10">
        <div class="form-check d-flex justify-content-center">
          <input class="form-check-input" type="radio" name="show_user" value="901" id="student">
          <label class="form-check-label ms-2" for="student">
            نمایش دانش آموزان کلاس 901
          </label>
        </div>
        <div class="form-check d-flex justify-content-center">
          <input class="form-check-input" type="radio" name="show_user" id="teacher" value="902">
          <label class="form-check-label ms-2" for="teacher">
            نمایش دانش آموزان کلاس 902
          </label>
        </div>
        <div class="form-check d-flex justify-content-center">
          <input class="form-check-input" type="radio" name="show_user" id="admin" value="903" checked>
          <label class="form-check-label ms-2" for="admin">
            نمایش دانش آموزان کلاس 903
          </label>
        </div>
        <div class="form-check d-flex justify-content-center">
          <input class="form-check-input" type="radio" name="show_user" id="all" value="all" checked>
          <label class="form-check-label ms-2" for="all">
            نمایش همه دانش آموزان
          </label>
        </div>
      </div>
      <button type="submit" name='<?php echo $btn_name; ?>' class="btn btn-outline-info shadow mb-1"><?php echo $btn_txt; ?></button>
    </form>
  </div>
  <div class="container-sm mt-3">
    <div class="row mt-5">
      <?php
      if (isset($_GET['show_user']) and $_GET['show_user'] != 1 and isset($result) and $result->num_rows > 0) {
        print_name();
      } elseif (isset($result) and $result->num_rows == 0) {
        empty_class();
      }
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>