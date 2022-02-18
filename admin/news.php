<?php 
include "../db_info.php";
$db = new mysqli($db_host,$db_username,$db_password,$users_db);
$db -> set_charset("utf8");
//set news
$errors = array();
if(isset($_POST['send_news'])){

        if(empty($_POST['title'])){ array_push($errors , "عنوان را به درستی وارد کنید <br>" ) ; }
        if(empty($_POST['txt'])){array_push($errors , "متن را به درستی وارد کنید <br>" ); }
        if(empty($_POST['access'])){array_push($errors , "مخاطب را به درستی وارد کنید <br>" ) ;}

        
        if(count($errors) == 0 ){
            $title = mysqli_real_escape_string($db,$_POST['title']);
            $txt = mysqli_real_escape_string($db,$_POST['txt']);
            $access = mysqli_real_escape_string($db,$_POST['access']);
            $my_code = $_SESSION['code'];
            
            $news_query = "INSERT INTO news (send_code,receive,title,txt,date)
            VALUES ('$my_code','$access','$title','$txt','date')";
            if ($db->query($news_query) === TRUE){
              $_SESSION['send_news'] = "اعلان ارسال شد.";
          }
        }
}
//delet news
if(isset($_GET['del'])){
    $id = $_GET['del'];
    $delete_query = "DELETE FROM news WHERE id='$id'";
    if ($db->query($delete_query) === TRUE){
        $_SESSION['delete'] = "اعلان با موفقیت حذف شد";
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
    <link rel="stylesheet" href="../css/news.css">
    <title>مدیریت کاربران </title>
</head>
<body>
    <div class="container-sm mt-5 text-center">
        <?php
        if(isset($_SESSION['delete'])){
            ?>
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <strong><?php echo $_SESSION['delete']; ?></strong>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         <?php
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['send_news'])){
            ?>
         <div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong><?php echo $_SESSION['send_news'] ?></strong>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         <?php
            unset($_SESSION['send_news']);
        }
        ?>
        <h1 class="border rounded mb-5 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">تابلو اعلانات</h1>
        <?php  if (count($errors) > 0) : ?>
          <div class="mt-1 mb-5 p-2 pt-3 bg-danger text-white border rounded-3 border-white d-flex flex-column align-items-center justify-content-center" style="color: red;">
        <?php foreach ($errors as $error) : ?>
  	      <p><?php echo $error ?></p>
    	<?php endforeach ?>
        </div>
        <?php endif ?>
    <form action="" method="POST">
            <div class="row">
                <div class="col-md-6 py-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">عنوان</span>
                        <input type="text" name="title" class="form-control" placeholder="عنوان..." aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon1">متن</span>
                          <textarea name="txt" class="form-control" placeholder="متن..." aria-label="Username" aria-describedby="basic-addon1"></textarea>
                      </div>
                </div>
                <div class="col-md-6">
                    <form action="" method="get">
                        <div class="border rounded mb-3 py-4 p-3 bg-info shadow-sm bg-opacity-10">
                          <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input" type="radio" name="access" id="student" value="student">
                            <label class="form-check-label ms-2" for="student">
                            ارسال به دانش آموزان
                        </label>
                    </div>
                    <div class="form-check d-flex justify-content-center">
                        <input  class="form-check-input" type="radio" name="access" id="teacher" value="teacher">
                        <label class="form-check-label ms-2" for="teacher">
                            ارسال به معلمان
                            </label>
                          </div>
                          <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input" type="radio" name="access" id="admin" value="admin">
                            <label class="form-check-label ms-2" for="admin">
                            ارسال به مدیران
                            </label>
                          </div>
                          <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input" type="radio" checked name="access" id="all" value="all">
                            <label class="form-check-label ms-2" for="all">
                            ارسال به همه کاربران
                            </label>
                          </div>
                          </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">   
                <button type="submit" name="send_news" class="py-2 mt-4 btn btn-outline-success shadow mb-5">ارسال</button>
                </div>
                <div class="col-md-4"></div>
            </div>
          </form>
          <hr>
    </div>
    <div class="container-sm">
        <div class="row">
            <?php
            //show news
        $read_news_query = "SELECT * FROM news";
        $result = $db->query($read_news_query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $send_code = $row['send_code'];
                $read_info_query = "SELECT * FROM info WHERE code='$send_code'";
                $result2 = $db->query($read_info_query);
                while($row2 = $result2->fetch_assoc()) {
                ?>
                <div class="col-md-6 border rounded-3 mb-3 bg-primary bg-opacity-10 shadow-sm">
                    <div class="text-center pt-4">
                        <h5 class=" fs-3"><?php echo $row['title']; ?></h5>
                    </div>
                    <p class="p-4"><?php echo $row['txt'] ?></p>
                    <p class="px-4 pt-3">فرستنده : <?php echo $row2['fname']." ".$row2['lname']; ?><br>مخاطبان : <?php echo $row['receive']; ?></p>
                <?php if($_SESSION['access'] == "admin"){
                    ?>
                    <div class="px-4 py-2 mb-3 text-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletenews">حذف این اعلان</button>
                    </div>
               <?php } ?>
                    <!-- Modal -->
                    <div class="modal fade" id="deletenews" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title text-danger fs-3" id="exampleModalLabel">اخطار!</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-danger bg-opacity-10 py-4 text-center">
                             میخواهید این اعلان را حذف کنید؟
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">خیر</button>
                              <button type="button" onclick="window.location='access.php?del=<?php echo $row['id']; ?>'" class="btn btn-outline-danger">بله</button>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <?php
            }
          }
        }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>