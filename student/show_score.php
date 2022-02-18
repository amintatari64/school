<?php 
session_start();
include "../db_info.php";
    if(!isset($_SESSION['ok'])){
        ?>
        <script>window.location='../login/index.php';</script>
        <?php
    }
    $name = "";
    $db = new mysqli($db_host,$db_username,$db_password,$users_db);
    $db -> set_charset("utf8");
     if(isset($_SESSION['fname'])){
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $code = $_SESSION['code'];
    
        $name = $fname . " " . $lname ;
    
        $user_check_query = "SELECT lesson,score FROM score WHERE code='$code'";
        $result = mysqli_query($db,$user_check_query);
     }
     if(isset($_POST['show_score']) and isset($_POST['lesson']) and !isset($_GET['hide_score'])){
       $lesson = $_POST['lesson'];
       if($lesson == "all"){$n_sql = "";}else{$n_sql = "AND lesson='$lesson'";}
       $sql = "SELECT lesson,score FROM score WHERE code='$code'". $n_sql ;
       $result2 = mysqli_query($db,$sql);
       $btn_txt = "پنهان کردن نمرات";
       $btn_link = "window.location='show_score.php?hide_score=1'";
       $_SESSION['url'] = "$_SERVER[REQUEST_URI]";
     }else{
     $btn_link = "";
     $btn_txt = "نمایش نمرات";
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
      <div class="container mt-5 d-flex flex-column justify-content-center align-items-center">
        <h3 class="border rounded mb-5 p-4 rounded-pill bg-warning bg-opacity-25 shadow-sm px-5">نمرات دانش آموز <?php echo $name; ?></h3>
        <?php
        if(isset($_POST['show_score']) and isset($_POST['lesson']) and !isset($_GET['hide_score'])){
         ?>
         <table class="table table-responsive table-hover table-striped">
            <thead>
              <tr>
                <th scope="col">نام درس</th>
                <th scope="col">نمره</th>
              </tr>
            </thead>
            <tbody>
         <?php
           while($user=mysqli_fetch_assoc($result2)){
             ?>
             <tr>
                <td><?php echo $user['lesson'] ?></td>
                <td><?php echo $user['score'] ?></td>
              </tr>
             <?php
           }?>
           </tbody>
          </table>
           <?php
        }
        ?>
        <form action="" method="post">
          <?php if($result->num_rows > 0){?>
            <div class="border text-center rounded mt-5 mb-3 p-5 bg-info shadow-sm bg-opacity-10">
            <h4 class="mb-5">درس مورد نظر را انتخاب کنید </h4>
            <?php 
            while($user=mysqli_fetch_assoc($result)){
              ?>
              <div class="form-check d-flex justify-content-center">
              <input class="form-check-input" type="radio" name="lesson" id="<?php echo $user['lesson'] ?>" value="<?php echo $user['lesson'] ?>">
              <label class="form-check-label ms-2" for="<?php echo $user['lesson'] ?>">
                <?php echo $user['lesson'] ?>
              </label>
              </div>
              <?php
            }
            if($result->num_rows > 0){
              ?>
              <div class="form-check d-flex justify-content-center">
              <input class="form-check-input" type="radio" name="lesson" id="all" value="all">
              <label class="form-check-label ms-2" for="all">
                همه دروس
              </label>
              </div>
              <button type="submit" name="show_score" class="btn btn-outline-success mt-5 p-2 fs-6 shadow">نمایش / پنهان کردن نمرات</button>
              <?php
              }?>
            </div>
            <?php
            }?>
        </form>
        <?php
        if($result->num_rows == 0){
          ?>
          <p class=" text-danger fs-2">هیچ نمره ای برای این دانش آموز ثبت نشده!</p>
          <img style="width:512px;height: 512px;" src="../images/no score.png" class="img-fluid">
          <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>