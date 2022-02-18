<?php 
session_start();
include "../db_info.php";
        if(!isset($_SESSION['ok']) or $_SESSION['access'] != "admin" ){
            ?>
            <script>window.location='../login/index.php';</script>
            <?php
        }

        $db = new mysqli($db_host,$db_username,$db_password,$users_db);
        $db -> set_charset("utf8");
        if(isset($_GET['search_btn'])){
            $code = $_GET['code'];
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            $query = "SELECT id,fname,lname,access,class FROM info WHERE code='$code'";
            $result = $db->query($query);
        }
?>
<html>
    <body>
        <form action="" method='get'>
             کد ملی : <input type='number' name='code'><br><br>
             <input type="submit" name="search_btn" value="جستجو">
            </form>
            <button onclick="window.location='usercontrol.php'">بازگشت</button>
        <p style="color: green;"><?php 
        if ( isset($_GET['search_btn']) and $result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
             echo $row['fname'] . " " . $row['lname'] . " با کد ملی :  " . $code. "<br>" . $row  ['access'] . " :  با دسترسی " ."<br><br> <a href='edit_user.php?uid=".$row['id']."&eucode=".$code."&eufname=".$row['fname']."&eulname=".$row['lname']."&euaccess=".$row['access']."&euclass=".$row['class']."&show_user=1'> ویرایش اطلاعات این کاربر </a><br>";
             if($_SESSION['code'] != $code){
                 echo "<br> <a href='usercontrol.php?ucode=".$code."&show_user=1'> حذف این کاربر </a>" . "<br><br>";
             }
                if($row['access'] == "student"){
                    echo "<a href='../teacher/show_user_score.php?code=".$code."&fname=".$row['fname']."&lname=".$row['lname']."&class=".$row['class']."&show_user=1'> نمایش نمرات این کاربر </a><br>" . "<br><br><br>";
                }
            }
          } elseif( isset($_GET['search_btn']) and $result->num_rows >! 0) {
            echo "0 results <br><br>";
          }
        ?></p>
    </body>
</html>