<?php 
include "../db_info.php";
if(!isset($_SESSION['ok'])){
    ?>
    <script>window.location='../login/index.php';</script>
    <?php
}
$db = new mysqli($db_host,$db_username,$db_password,$users_db);
$db -> set_charset("utf8");
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
</head>
<body>
    <div class="container-sm mt-5 text-center">
    </div>
    <div class="container-sm">
        <div class="row">
            <?php
            $access = $_SESSION['access'];
            //show news
        $read_news_query = "SELECT * FROM news WHERE receive='$access' or receive='all'";
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
                    <p class="px-4 pt-3">فرستنده : <?php echo $row2['fname']." ".$row2['lname']; ?></p>
                </div>
                <?php
            }
          }
        }else{
          ?>
          <div class="container-sm text-center">
          <p class=" text-danger fs-2">هیچ اعلانی وجود ندارد!</p>
          <img style="width:512px;height: 512px;" src="../images/no score.png" class="img-fluid">
          </div>
          <?php
        }
            ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>