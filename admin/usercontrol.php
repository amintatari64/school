<?php 
    session_start();
    include "../db_info.php";
    if(!isset($_SESSION['ok']) or $_SESSION['access'] != "admin" ){
        ?>
        <script>window.location='../login/index.php';</script>
        <?php
    }
    if(isset($_SESSION['darkmode'])){
      ?>
      <script>
        document.body.style.background = "#5e5e5e"
      </script>
      <?php
    }
    //delete users
    if(isset($_GET['ducode'])){
        $ucode = $_GET['ducode'];

        if($ucode != $_SESSION['code']){
        $db = new mysqli($db_host,$db_username,$db_password,$users_db);
        $db -> set_charset("utf8");
        $query1 = "DELETE FROM info
        WHERE code = $ucode";

        $check_query = "SELECT * FROM score WHERE code='$ucode'";
        $result = $db->query($check_query);
        if($result->num_rows > 0){
        $query2 = "DELETE FROM score
        WHERE code = $ucode";
        }

        if ($db->query($query1) === TRUE){
            if($result->num_rows > 0 and $db->query($query2) === TRUE){
                $delete = "کاربر و نمره هایش با موفقیت حذف شدند";
            }else{
            $delete = "کاربر با موفقیت حذف شد";
            }
        }else{
            $delete = "خطایی رخ داد و کار بر حذف نشد";
        }
    }elseif($ucode == $_SESSION['code']){
        $delete = "شما نمیتوانید خودتان را حذف کنید";
    }elseif($_SESSION['access'] != "admin"){
        $delete = "شما دسترسی حذف کاربران را ندارید";
    }
    }
    $errors = array();
    $db = new mysqli($db_host,$db_username,$db_password,$users_db);
    $db -> set_charset("utf8");
    if(isset($_POST['submit_signup'])){
        if(empty($_POST['fname'])){ array_push($errors , "نام را به درستی وارد کنید <br>" ) ; }
        if(empty($_POST['lname'])){array_push($errors , "نام خانوادگی را به درستی وارد کنید <br>" ); }
        if(empty($_POST['code'])){array_push($errors , "کد ملی را به درستی وارد کنید <br>" ) ;}
        if(empty($_POST['access'])){array_push($errors , "دسترسی را به درستی وارد کنید <br>" );}
        if(empty($_POST['class'])){array_push($errors , "شماره کلاس  را به درستی وارد کنید <br>" );}

        $fname = mysqli_real_escape_string($db,$_POST['fname']);
        $lname = mysqli_real_escape_string($db,$_POST['lname']);
        $code = mysqli_real_escape_string($db,$_POST['code']);
        $access = mysqli_real_escape_string($db,$_POST['access']);
        $class = mysqli_real_escape_string($db,$_POST['class']);

        if(substr($code,1) == 0 ){
            $code = substr($code,1);
        }
        $user_check_query = "SELECT * FROM info WHERE code='$code' LIMIT 1 ";
        $result = mysqli_query($db,$user_check_query);
        $user = mysqli_fetch_assoc($result);

        if($user){
            if($user['code'] === $code ){
                array_push($errors,"کاربر دیگری با این کد ملی موجود است <br>") ;
            }
        }
        if(count($errors) == 0 ){
            $signup_query = "INSERT INTO info (fname,lname,code,access,class)
            VALUES ('$fname','$lname','$code','$access','$class')";
            mysqli_query($db,$signup_query);
            $_SESSION['signup_ok'] = " کاربر " . $fname . " " . $lname ." با کد ملی "  . $code . " با موفقیت ایجاد شد" . "<br> دسترسی این کاربر : " . $access . "<br>" . "شماره کلاس : " . $class;
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
    <link rel="stylesheet" href="../css/usercontrolAdmin.css">
    <title>مدیریت کاربران </title>
</head>
<body>
    <div class="container-sm mt-5 text-center">
    <?php
       //check edit
       if(isset($_GET['edit']) and isset($_SESSION['edit']) ){
         $edit_report = $_SESSION['edit'];
       ?>
         <div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong><?php echo $edit_report; ?></strong>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
       <?php
       unset($_SESSION['edit']);
        }
        if(isset($_SESSION['signup_ok'])){
            ?>
            
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo $_SESSION['signup_ok']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
            <?php
            unset($_SESSION['signup_ok']);
        }
        if(isset($delete)){
        ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong style="color: red;"><?php echo $delete; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php 
          $delete = "";
          unset($delete);
        } ?>
          <h1 class="border rounded mb-5 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">افزودن کاربر جدید</h1>
        <?php  if (count($errors) > 0) : ?>
          <div class="mt-1 mb-5 p-2 pt-3 bg-danger text-white border rounded-3 border-white d-flex flex-column align-items-center justify-content-center" style="color: red;">
        <?php foreach ($errors as $error) : ?>
  	      <p><?php echo $error ?></p>
    	<?php endforeach ?>
        </div>
        <?php endif ?>
          <form class="mb-5" action="" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">نام</span>
            <input type="text" name="fname" class="form-control" placeholder="نام..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1">نام خانوادگی</span>
            <input type="text" name="lname" class="form-control" placeholder="نام خانوادگی..." aria-label="Username" aria-describedby="basic-addon1">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">شماره کلاس</span>
            <input style="direction: rtl;" type="number" name="class" class="form-control" placeholder="شماره کلاس..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1">کد ملی </span>
            <input style="direction: rtl;" type="number" name="code" class="form-control" placeholder="کد ملی..." aria-label="Username" aria-describedby="basic-addon1">
          </div>
          <h5 class="fs-6 text-danger">در صورت لزوم شماره کلاس را سه عدد صفر بنویسید</h5>
          <div class="border container d-flex justify-content-around align-items-center rounded mt-5 p-3 bg-warning shadow-sm bg-opacity-10">
              <h4 class="">دسترسی : </h4>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="radio" name="access" id="admin" value="admin">
            <label class="form-check-label ms-2" for="admin">
              مدیر
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="radio" name="access" id="teacher" value="teacher">
            <label class="form-check-label ms-2" for="teacher">
              معلم
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="radio" name="access" id="student" value="student" checked>
            <label class="form-check-label ms-2" for="student">
              دانش آموز
            </label>
          </div>
          </div>
          <button type="submit" name="submit_signup" class="btn btn-outline-primary mt-3 p-2 fs-6 shadow">افزودن کاربر</button>
        </form>
        <div class="container-sm mt-3">
            <div class="row mt-5">
      <?php 
    //form disable
    $disable = "";
    if( isset($_GET['show_user']) and $_GET['show_user'] != 1 ){
        $btn_txt = "پنهان کردن لیست کاربران";
        $btn_link = "usercontrol.php?show_user=1";
        $access = $_GET['show_user'];
        
        if($access == "all"){$n_sql = "";}else{$n_sql = "WHERE access='$access'";}
        $sql = "SELECT id,fname, lname, code,access,class FROM info ". $n_sql ;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row['class'] == "000" ){
              ?>
              <div class="col-lg-4 text-center">
                  <p class="py-4 bg-success bg-opacity-75 rounded-3 shadow-sm">
                <br><?php echo $row['fname'] . " " . $row['lname'] . " با کد ملی : " . $row['code']; ?>
                <br>دسترسی : <?php echo $row['access']; ?>
                <br><a class="btn btn-info m-2" href="<?php echo "edit_user.php?uid=".$row['id']."&eucode=".$row['code']."&eufname=".$row['fname']."&eulname=".$row['lname']."&euaccess=".$row['access']."&euclass=".$row['class']."&show_user=1"; ?>">ویرایش اطلاعات</a>
                <?php
                if($_SESSION['code'] != $row['code']){
                ?>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete" >حذف</button>
                <!-- Modal -->
                <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h5 class="modal-title text-danger text-center fs-3" id="exampleModalLabel">اخطار!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body bg-danger bg-opacity-25">
                        آیا میخواهید این کاربر را حذف کنید؟!
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">خیر</button>
                        <a class="btn btn-outline-danger" href="<?php echo "usercontrol.php?ducode=".$row['code']."&show_user=1" ?>">بله</a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </p>
            </div>
          
              <?php
            }else{
                ?>
                <div class="col-lg-4 text-center">
                  <p class="py-4 bg-success bg-opacity-75 rounded-3 shadow-sm">
                <br><?php echo $row['fname'] . " " . $row['lname'] . " با کد ملی : " . $row['code']; ?>
                <br>دسترسی : <?php echo $row['access']; ?>
                <br>شماره کلاس : <?php echo $row['class']; ?>
                <br><a class="btn btn-info m-2" href="<?php echo "edit_user.php?uid=".$row['id']."&eucode=".$row['code']."&eufname=".$row['fname']."&eulname=".$row['lname']."&euaccess=".$row['access']."&euclass=".$row['class']."&show_user=1"; ?>">ویرایش اطلاعات</a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-s" >حذف</button>
                </p>
                <!-- Modal -->
                <div class="modal fade" id="delete-s" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h5 class="modal-title text-danger text-center fs-3" id="exampleModalLabel">اخطار!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body bg-danger bg-opacity-25">
                        آیا میخواهید این کاربر را حذف کنید؟!
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">خیر</button>
                        <a class="btn btn-outline-danger" href="<?php echo "usercontrol.php?ducode=".$row['code'] ?>">بله</a>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <?php
            }
        }
        ?>
        </div>
        </div>
        <?php
        
          } else {
            ?>
            <div class="container-sm text-center">
            <p class=" text-danger fs-2">هیچ کاربری وجود ندارد!</p>
            <img style="width:512px;height: 512px;" src="../images/no score.png" class="img-fluid">
            </div>
            <?php
          }
          $disable = "disabled";
     }else{
         $btn_txt = "نمایش کاربران";
         $btn_link = "usercontrol.php?show_user=2";
        }
        ?>
      <?php if($btn_txt == "پنهان کردن لیست کاربران"){$d_none = "style='display:none;'";}else{$d_none = "";} ?>
        <form action="" method="get">
        <div class="border d-md-flex justify-content-around align-items-center rounded mt-md-5 mb-3 p-3 bg-info shadow-sm bg-opacity-10">
          <div class="form-check d-flex justify-content-center">
            <input <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="student" value="student">
            <label class="form-check-label ms-2" for="student">
            نمایش دانش آموزان
        </label>
    </div>
    <div class="form-check d-flex justify-content-center">
        <input <?php echo $disable; ?>  class="form-check-input" type="radio" name="show_user" id="teacher" value="teacher">
        <label class="form-check-label ms-2" for="teacher">
            نمایش معلمان
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="admin" value="admin" checked>
            <label class="form-check-label ms-2" for="admin">
            نمایش مدیران سایت
            </label>
          </div>
          <div class="form-check d-flex justify-content-center">
            <input <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="all" value="all" checked>
            <label class="form-check-label ms-2" for="all">
            نمایش همه کاربران
            </label>
          </div>
          </div>
          <button type="submit" class="btn btn-outline-primary mb-5 p-2 fs-6 shadow" onclick="window.location='<?php echo $btn_link; ?>'"><?php echo $btn_txt; ?></button>
        </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>