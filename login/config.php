<?php
include "../db_info.php";
session_start();

$uname = "";
$password = "";
$errors = array();

$db = new mysqli($db_host,$db_username,$db_password,$users_db);
$db -> set_charset("utf8");
if(isset($_SESSION['access'])){
    if($_SESSION['access'] == "admin"){echo "<script>window.location='../index.php?usercontrol=1'</script>";}
    if($_SESSION['access'] == "teacher"){echo "<script>window.location='../index.php?controlscore=1'</script>";}
    if($_SESSION['access'] == "student"){echo "<script>window.location='../index.php?showscore=1'</script>";}
}
if(isset($_POST['submit_login'])){
    $uname = mysqli_real_escape_string($db,$_POST['uname']);
    $password = mysqli_real_escape_string($db,$_POST['password']);


    if(empty($uname)){ array_push($errors,"نام کاربری را وارد کنید");}
    if(empty($password)){ array_push($errors,"رمز عبور خود را وارد کنید ");}


    if(count($errors) == 0 and $uname == $password ){
         $code = $uname;
         $query = "SELECT fname,lname,access FROM info WHERE code='$code'";
         $result = mysqli_query($db,$query);
         $info = $result->fetch_assoc();
         if(mysqli_num_rows($result) > 0){
             $_SESSION['code'] = $code;
             $_SESSION['fname'] = $info['fname'];
             $_SESSION['lname'] = $info['lname'];
             $_SESSION['access'] = $info['access'];
             $_SESSION['ok'] = "با موفقیت وارد شدید";
             if($_SESSION['access'] == "student"){
             echo "<script> window.location = '../index.php?showscore=1' </script>";
             }elseif($_SESSION['access'] == "teacher"){
             echo "<script> window.location = '../index.php?controlscore=1' </script>";
             }else{
             echo "<script> window.location = '../index.php?usercontrol=1' </script>";
             }
         }else{
             array_push($errors,"نام کاربری یا رمز عبور اشتباه است");
         }
    }elseif(count($errors) == 0 and $uname != $password){
        array_push($errors,"نام کاربری یا رمز عبور اشتباه است");
    }

}
?>