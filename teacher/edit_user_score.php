<?php 
session_start();
include "../db_info.php";
if(!isset($_SESSION['ok']) or !isset($_SESSION['access']) ){
    ?>
    <script>window.location='../login/index.php';</script>
    <?php
}
$name = "";
$db = new mysqli($db_host,$db_username,$db_password,$users_db);
$db -> set_charset("utf8");
$thisurl = $_SERVER['REQUEST_URI'];


if(isset($_GET['fname'])){
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $code = $_GET['code'];
    $class = $_GET['class'];

    $name = $fname . " " . $lname ;

    $user_check_query = "SELECT lesson,score FROM score WHERE code='$code' LIMIT 5";
        $result = mysqli_query($db,$user_check_query);
 }
 if(isset($_POST['show_score']) and isset($_POST['lesson']) and !isset($_GET['hide_score'])){
   $lesson = $_POST['lesson'];
   $sql = "SELECT id,lesson,score FROM score WHERE lesson='$lesson'";
   $result2 = mysqli_query($db,$sql);
   $btn_txt = "پنهان کردن نمرات";
   $btn_link = "window.location='show_user_score.php?hide_score=1'";
 }else{
 $btn_link = "";
 $btn_txt = "نمایش نمرات";
 }
 $errors = array();
 if(isset($_POST['edit_score_btn'])){
    if(empty($_POST['lesson'])){array_push($errors , "نام درس را به درستی وارد کنید <br>" ) ;}
    if(empty($_POST['score'])){array_push($errors , "نام درس را به درستی وارد کنید <br>" ) ;}

    $lesson = mysqli_real_escape_string($db,$_POST['lesson']);
    $score = mysqli_real_escape_string($db,$_POST['score']);
    $id = mysqli_real_escape_string($db,$_POST['id']);

        
      if(count($errors) == 0 ){
             $insert = "UPDATE score
             SET lesson='$lesson', score='$score'
             WHERE code='$code' AND id='$id' ";
             if ($db->query($insert) === TRUE) {
             $_SESSION['edit_score'] = " نمره  " . $score . " درس " . $lesson . " برای دانش آموز " . $fname . " " . $lname . " با موفقیت ثبت شد";
             }else{
                 $_SESSION['edit_score'] = " عملیات انجام نشد";
             }
        }
 }elseif(isset($_POST['delete'])){
   $id = $_POST['delete'];

   $delete = "DELETE FROM score
   WHERE id = '$id'";
   if ($db->query($delete) === TRUE){
    // echo "<script>window.location='$thisurl'</script>";
     $_SESSION['delete_score'] = " نمره با موفقیت حذف شد ";
   }else{
    $_SESSION['delete_score'] = " عملیات انجام نشد";
   // echo "<script>window.location='$thisurl'</script>";
    }
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
    <link rel="stylesheet" href="../css/showscore.css">
  </head>
  <body>
      <div class="container mt-5 text-center d-flex flex-column justify-content-center align-items-center">
        <h1 class="border rounded mb-5 p-4 rounded-pill bg-warning bg-opacity-25 shadow-sm px-5">ویرایش نمرات دانش آموز <?php echo $name; ?></h1>
        <?php  if (count($errors) > 0) : ?>
          <div class="mt-1 mb-5 p-2 pt-3 bg-danger text-white border rounded-3 border-white d-flex flex-column align-items-center justify-content-center" style="color: red;">
        <?php foreach ($errors as $error) : ?>
  	      <p><?php echo $error ?></p>
    	<?php endforeach ?>
        </div>
        <?php endif?>
        <?php
        if(isset($_SESSION['delete_score'])){
          ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
           <strong><?php echo $_SESSION['delete_score']; ?></strong>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          <?php
          unset($_SESSION['delete_score']);
        }
        if(isset($_SESSION['edit_score'])){
          ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
           <strong><?php echo $_SESSION['edit_score']; ?></strong>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          <?php
          unset($_SESSION['edit_score']);
        }
        ?>
        <?php
        if(isset($_POST['show_score']) and isset($_POST['lesson']) and !isset($_GET['hide_score'])){
        ?>
        <form action="" method="POST">
        <table class="table table-responsive table-hover table-striped">
          <thead>
            <tr>
              <th scope="col">آیدی</th>
              <th scope="col">نام درس</th>
              <th scope="col">نمره</th>
              <th scope="col">حذف</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while($user=mysqli_fetch_assoc($result)){
                while($user2=mysqli_fetch_assoc($result2)){
                  ?>
              <tr>
                <td><?php echo "<input class='form-control' type='text' name='id' value='". $user2['id'] . "' readonly>" ?></td>
                <td><?php echo "<input class='form-control' type='text' name='lesson' value='". $user['lesson'] . "'>" ?></td>
                <td><?php echo "<input class='form-control' type='text' name='score' value='". $user['score'] . "'>" ?></td>
                <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete" onclick="<?php $info = $user2['id']; ?>">حذف این نمره</button></td>
              </tr>
              <?php }} ?>
            </tbody>
          </table>
          <button type="submit" name='edit_score_btn' class="btn btn-success shadow-sm">ثبت </button>
        </form>
          <!-- Modal -->
          <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h5 class="modal-title fs-1 text-danger text-center" id="exampleModalLabel">اخطار!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="fs-5 py-4 modal-body bg-danger bg-opacity-10">
                  آیا میخواهید این نمره را حذف کنید؟
                </div>
                <div class="modal-footer">
                  <form action="" method="post">
                  <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">خیر</button>
                  <button type="submit" name="delete" value="<?php echo $info; ?>" class="btn btn-outline-danger">بله</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
      <?php } ?>
        <form action="" method="post">
            <div class="border text-center rounded mt-5 mb-3 p-5 bg-info shadow-sm bg-opacity-10">
                <h4 class="">درس مورد نظر را انتخاب کنید </h4>
                <?php 
                 while($user=mysqli_fetch_assoc($result)){
                   ?>
                   <div class="form-check d-flex mt-4 justify-content-center">
                     <input class="form-check-input" type="radio" name="lesson" id="<?php echo $user['lesson']; ?>" value="<?php echo $user['lesson']; ?>">
                     <label class="form-check-label ms-2" for="<?php echo $user['lesson']; ?>">
                       <?php echo $user['lesson']; ?>
                     </label>
                   </div>
                   <?php
                  }
                   ?>
            <button type="submit" name="show_score" class="btn btn-outline-success mt-4 p-2 fs-6 shadow">نمایش / پنهان کردن نمرات</button>
            </div>
        </form>
        <a href="<?php echo $_SESSION['url']; ?>" class="btn btn-outline-danger px-3 shadow-sm mt-5 d-block">بازگشت</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>