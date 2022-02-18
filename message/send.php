<?php
session_start();
include "../db_info.php";
$db = new mysqli($db_host, $db_username, $db_password, $users_db);
$db->set_charset("utf8");
if (isset($_POST['send_msg'])) {
    $receiv_code = $_GET['code'];
    $send_code = $_SESSION['code'];

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $msg_txt = mysqli_real_escape_string($db, $_POST['ms_txt']);


    $query = "INSERT INTO message (send_code,receiv_code,txt,ifread)
        VALUES ('$send_code','$receiv_code','$msg_txt','no')";
    if ($db->query($query) === TRUE) {
        $_SESSION['message_send'] = "پیام شما با موفقیت برای $name ارسال شد";
        echo "<script>alert('". $_SESSION['message_send'] ."');window.location='index.php';</script>";
    } else {
        $_SESSION['message_send'] = "پیام شما برای $name ارسال نشد";
        echo "<script>alert('". $_SESSION['message_send'] ."');window.location='index.php';</script>";
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
    <link rel="stylesheet" href="../css/sendmessage.css">
    <title>مدیریت کاربران </title>
</head>

<body>
    <div id="container" class="container-sm mt-5 text-center">
        <h3 class="border rounded mb-3 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">ارسال پیام به <?php echo $_GET['name']; ?></h3>
        <form action="" onsubmit="return check()" method="post">
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">گیرنده</span>
                    <input type="text" name="name" class="form-control" readonly value="<?php echo $_GET['name']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">متن پیام</span>
                    <textarea type="text" id="ms_txt" name="ms_txt" class="form-control" placeholder="متن پیام..." aria-label="Username" aria-describedby="basic-addon1"></textarea>
                </div>
            </div>
            <input type="submit" class="btn btn-success mt-2 p-2" name="send_msg" value="ارسال پیام">
            <input type="button" value="بازگشت" class="btn btn-outline-danger mt-2 p-2" onclick="window.location='<?php echo  $_SESSION['url'] ?>'">
        </form>
    </div>
    <script>
        function check() {
            if (document.getElementById("ms_txt").value == 0) {
                document.getElementById("container").innerHTML+="<div class ='mt-3 mb-3 p-2 pt-3 bg-danger text-white border rounded-3 border-white d-flex flex-column align-items-center justify-content-center' style='color: red;'><h3 id='error'>متن پیام را به درستی وارد کنید</h3></div>"
                return false;
            }
        }
    </script>
</body>