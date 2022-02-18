<?php
session_start();
include "../db_info.php";
//edit users
$edit = "";
if(isset($_GET['eucode'])){
    $code = $_GET['eucode'];
    $fname = $_GET['eufname'];
    $lname = $_GET['eulname'];
    $access = $_GET['euaccess'];
    $class = $_GET['euclass'];
    $id = $_GET['uid'];
    $errors = array();
    if(isset($_POST['submit_edit'])){
        $db = new mysqli($db_host,$db_username,$db_password,$users_db);
        $db -> set_charset("utf8");
        if(empty($_POST['fname']) and $_POST['fname'] != $fname){ array_push($errors , "نام را به درستی وارد کنید <br>" ) ; }
        if(empty($_POST['lname']) and $_POST['lname'] != $lname){array_push($errors , "نام خانوادگی را به درستی وارد کنید <br>" ); }
        if(empty($_POST['access']) and $_POST['access'] != $access){array_push($errors , "دسترسی را به درستی وارد کنید <br>" );}
        if(empty($_POST['class']) and $_POST['class'] != $class){array_push($errors , "شماره کلاس  را به درستی وارد کنید <br>" );}
        if(empty($_POST['code']) and $_POST['code'] != $code){array_push($errors , "کد ملی را به درستی وارد کنید <br>" );}

        $ofname = mysqli_real_escape_string($db,$_POST['fname']);
        $olname = mysqli_real_escape_string($db,$_POST['lname']);
        $oaccess = mysqli_real_escape_string($db,$_POST['access']);
        $oclass = mysqli_real_escape_string($db,$_POST['class']);
        $ocode = mysqli_real_escape_string($db,$_POST['code']);

        $user_check_query = "SELECT * FROM info WHERE code='$ocode' LIMIT 1 ";
        $result = mysqli_query($db,$user_check_query);
        $user = mysqli_fetch_assoc($result);

        if($user){
            if($user['code'] === $ocode and $user['code'] != $code){
         array_push($errors,"کاربر دیگری با این کد ملی ثبت شده است");
            }
        }

        if(count($errors) == 0 ){
            $query = "UPDATE info SET fname='$ofname',lname='$olname',code='$ocode',access='$oaccess',class='$oclass' WHERE id=$id ";
            mysqli_query($db,$query);
            if ($db->query($query) === TRUE) {
                $_SESSION['edit'] = " کاربر " . $ofname . " " . $olname ." با کد ملی "  . $ocode . " با موفقیت ویرایش شد" . "<br>". " دسترسی این کاربر : " . $oaccess . "<br> شماره کلاس : " . $class;
                echo "<script>window.location='usercontrol.php?edit=report&show_user=1'</script>";
              } else {
                $_SESSION['edit'] = " در هنگام انجام عملیات خطایی رخ داد";
                echo "<script>window.location='usercontrol.php?edit=report&show_user=1'</script>";
              }
        }
        
    }
}else{
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
    <link rel="stylesheet" href="../css/edituser.css">
    <title>مدیریت کاربران </title>
</head>
<body>
    <div class="container-sm mt-5 text-center">
           <?php  if (count($errors) > 0) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php foreach ($errors as $error) : ?>
              <strong><?php echo $error; ?></strong>
        	<?php endforeach ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            <?php endif ?>
          <h1 class="border rounded mb-5 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">ویرایش اطلاعات کاربر</h1>
          <form class="mb-5" action="" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">نام</span>
            <input type="text" value="<?php echo $fname ?>" name="fname" class="form-control" placeholder="نام..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1">نام خانوادگی</span>
            <input type="text" value="<?php echo $lname ?>" name="lname" class="form-control" placeholder="نام خانوادگی..." aria-label="Username" aria-describedby="basic-addon1">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">شماره کلاس</span>
            <input style="direction: rtl;" type="number" value="<?php echo $class ?>" name="class" class="form-control" placeholder="شماره کلاس..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1">کد ملی </span>
            <input style="direction: rtl;" type="number" value="<?php echo $code ?>" name="code" class="form-control" placeholder="کد ملی..." aria-label="Username" aria-describedby="basic-addon1">
          </div>
          <h5 class="fs-6 text-danger">در صورت لزوم شماره کلاس را سه عدد صفر بنویسید</h5>
          <div class="border rounded mt-5 mb-3 p-3 bg-warning shadow-sm bg-opacity-10">
              <h4 class="">دسترسی : </h4>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" <?php if($access == "admin"){echo "checked";} ?> type="radio" name="access" id="admin" value="admin">
            <label class="form-check-label ms-2" for="admin">
              مدیر
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" <?php if($access == "teacher"){echo "checked";} ?> type="radio" name="access" id="teacher" value="teacher">
            <label class="form-check-label ms-2" for="teacher">
              معلم
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" <?php if($access == "student"){echo "checked";} ?> type="radio" name="access" id="student" value="student">
            <label class="form-check-label ms-2" for="student">
              دانش آموز
            </label>
          </div>
          </div>
          
          <button type="submit" id='submit_edit' name="submit_edit" class="btn btn-success mt-3 p-2 fs-6 shadow">ثبت</button>
          <a class="btn btn-outline-success mt-3 p-2 fs-6 shadow" id="serach-btn" href="usercontrol.php?show_user=1">بازگشت</a>
        </form>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>