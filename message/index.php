<?php
session_start();
include "../db_info.php";
if (!isset($_SESSION['ok'])) {
?>
    <script>
        window.location = '../login/index.php';
    </script>
<?php
}
$disable = "";
if (isset($_GET['show_user']) and $_GET['show_user'] != 1) {
    $disable = "disabled";
}
$db = new mysqli($db_host, $db_username, $db_password, $users_db);
$db->set_charset("utf8");
if (!isset($btn_txt)) {
    $btn_txt = "نمایش / پنهان کردن کاربران";
}
//delet_msg
if (isset($_GET['del'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];

    $del_query = "DELETE FROM message
    WHERE id = '$id'";

    if ($db->query($del_query) === TRUE) {
        $_SESSION['delete_msg'] = "پیام ارسال شده به $name با موفقیت حذف شد";
    } else {
        $_SESSION['delete_msg'] = "پیام ارسال شده به $name حذف شد";
    }
}
//access
$d_input_none = "";
$lable_s_txt = "نمایش دانش آموزان";
$lable_a_txt = "نمایش همه کاربران";
if ($_SESSION['access'] == "student") {
    $d_input_none = "style='display:none;'";
    $lable_s_txt = "";
    $lable_a_txt = "";
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
    <link rel="stylesheet" href="../css/mssage.css">
    <title>مدیریت کاربران </title>
</head>

<body>
    <div class="container-sm mt-5 text-center">
        <?php
        if (isset($_SESSION['delete_msg'])) {
        ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['delete_msg']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['delete_msg']);
        }
        ?>
        <h1 class="border rounded mb-3 p-4 rounded-pill bg-primary bg-opacity-25 shadow-sm">مدیریت پیام ها</h1>
        <hr>
        <div class="container-sm mt-3">
            <div class="row text-center">
                <div class="col-md-1"></div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#riceive" class="btn btn-primary border col-md-4 mb-3 mt-3 rounded p-4 rounded-3 bg-success bg-opacity-25 shadow-sm text-black fs-4 position-relative">
                    نمایش پیام های دریافتی
                    <?php
                    //alert for new message
                    $my_code = $_SESSION['code'];
                    $query = "SELECT * FROM message WHERE receiv_code='$my_code' AND ifread='no'";
                    $result = $db->query($query);
                    if ($result->num_rows > 0) {
                    ?>
                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    <?php
                    }
                    ?>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="riceive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">پیام های دریافتی</h5>
                                <button type="button" onclick="history.go();" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <?php
                                    //show_msg
                                    function check_new()
                                    {
                                        global $db;
                                        $my_code = $_SESSION['code'];
                                        $query = "SELECT * FROM message WHERE receiv_code='$my_code' AND ifread='no'";
                                        $query2 = "SELECT * FROM message WHERE receiv_code='$my_code'";

                                        $result = $db->query($query);
                                        if ($result->num_rows > 0) {
                                            echo "<p class='my-2 mb-4'>پیام های جدید </p>";
                                            while ($row = $result->fetch_assoc()) {
                                                $info_query = "SELECT * FROM info WHERE code='" . $row['send_code'] . "'";
                                                $info_result = $db->query($info_query);
                                                $info = $info_result->fetch_assoc();
                                    ?>
                                                <div class="col-12 mb-2 border rounded-3 shadow-sm bg-info bg-opacity-10 p-4">
                                                    <p class="fs-4">فرستنده : <?php echo $info['fname'] . " " . $info['lname']; ?></p>
                                                    <p class="pt-4"><?php echo $row['txt'] ?></p>
                                                </div>
                                                <?php
                                                $read_qurey = "UPDATE message
                                                SET ifread='yes'
                                                WHERE id='" . $row['id'] . "'";
                                                $db->query($read_qurey);
                                            }
                                        } else {
                                            $result2 = $db->query($query2);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result2->fetch_assoc()) {
                                                    $info_query = "SELECT * FROM info WHERE code='" . $row['send_code'] . "'";
                                                    $info_result = $db->query($info_query);
                                                    $info = $info_result->fetch_assoc();
                                                    if (isset($info['fname'])) {
                                                ?>
                                                        <div class="col-12 mb-2 border rounded-3 shadow-sm bg-primary bg-opacity-10 p-4">
                                                            <p class="fs-4">فرستنده : <?php echo $info['fname'] . " " . $info['lname']; ?></p>
                                                            <p class="pt-4"><?php echo $row['txt'] ?></p>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-12 mb-2 border rounded-3 shadow-sm bg-primary bg-opacity-10 p-4">
                                                            <p class="fs-4 text-danger">فرستنده : کاربر حذف شده</p>
                                                            <p class="pt-4"><?php echo $row['txt'] ?></p>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <div class="container-sm text-center">
                                                    <p class=" text-danger fs-2">هیچ پیامی وجود ندارد!</p>
                                                    <img style="width:400px;height: 400px;" src="../images/no score.png" class="img-fluid">
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    check_new();
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" onclick="history.go();" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <button type="button" class="btn btn-primary border col-md-4 mb-3 mt-3 rounded p-4 rounded-3 bg-secondary bg-opacity-25 shadow-sm text-black fs-4" data-bs-toggle="modal" data-bs-target="#send">نمایش پیام های ارسالی</button>
                <div class="col-md-1"></div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="send" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">پیام های ارسالی</h5>
                            <button onclick="<?php $delete_info = ""; ?>" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <?php include "my_send_msg.php"; ?>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button onclick="<?php $delete_info = ""; ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title text-danger text-center fs-3" id="exampleModalLabel">اخطار!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger bg-opacity-25">
                            آیا میخواهید این پیام را حذف کنید؟!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">خیر</button>
                            <a class="btn btn-outline-danger" href="<?php echo "index.php?del=1&id=" . $_SESSION['delete_msg_id'] . "&name=" . $_SESSION['delete_msg_fname'] . " " . $_SESSION['delete_msg_lname']; ?>">بله</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <h4 class="border col-md-6 mt-3 rounded p-4 rounded-pill bg-warning bg-opacity-25 shadow-sm">ارسال پیام</h4>
            <div class="col-md-3"></div>
        </div>
        <?php if ($btn_txt == "پنهان کردن لیست کاربران") {
            $d_none = "style='display:none;'";
        } else {
            $d_none = "";
        } ?>
        <form action="" method="get">
            <div <?php echo $d_none; ?> class="border rounded mt-2 mb-3 p-3 bg-info shadow-sm bg-opacity-10">
                <div class="form-check d-flex justify-content-center">
                    <input <?php echo $d_input_none; ?> <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="student" value="student" checked>
                    <label class="form-check-label ms-2" for="student">
                        <?php echo $lable_s_txt; ?>
                    </label>
                </div>
                <div class="form-check d-flex justify-content-center">
                    <input <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="teacher" value="teacher">
                    <label class="form-check-label ms-2" for="teacher">
                        نمایش معلمان
                    </label>
                </div>
                <div class="form-check d-flex justify-content-center">
                    <input <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="admin" value="admin">
                    <label class="form-check-label ms-2" for="admin">
                        نمایش مدیران سایت
                    </label>
                </div>
                <div class="form-check d-flex justify-content-center">
                    <input <?php echo $d_input_none; ?> <?php echo $disable; ?> class="form-check-input" type="radio" name="show_user" id="all" value="all">
                    <label class="form-check-label ms-2" for="all">
                        <?php echo $lable_a_txt; ?>
                    </label>
                </div>
            </div>
            <button type="submit" onclick="window.location='<?php echo $btn_link; ?>'" class="btn btn-primary shadow mb-5"><?php echo $btn_txt; ?></button>
        </form>
    </div>
    <div class="container-sm mt-3">
        <div class="row mt-5">
            <?php
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            if (isset($_GET['show_user']) and $_GET['show_user'] != 1) {
                $btn_txt = "پنهان کردن لیست کاربران";
                $btn_link = "usercontrol.php?show_user=1";
                $access = $_GET['show_user'];


                if ($access == "all") {
                    $n_sql = "";
                } else {
                    $n_sql = "WHERE access='$access'";
                }
                $sql = "SELECT id,fname, lname, code,access,class FROM info " . $n_sql;
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($_SESSION['code'] != $row['code']) {
            ?>
                            <div class="col-lg-4 text-center">
                                <p class="py-3 bg-success bg-opacity-75 rounded-3 shadow-sm">
                                    <br><?php echo $row['fname'] . " " . $row['lname'] ?>
                                    <br>دسترسی : <?php echo $row['access']; ?>
                                    <br>شماره کلاس : <?php echo $row['class']; ?>
                                    <br>
                                    <button type="button" class="btn btn-info m-2 mt-4" onclick="window.location='send.php?name=<?php echo $row['fname'].' '.$row['lname'].'&code='.$row['code']; ?>'">
                                        ارسال پیام به این کاربر
                                    </button>
                                </p>
                            </div>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <div class="container-sm text-center">
                        <p class=" text-danger fs-2">هیچ کاربری وجود ندارد!</p>
                        <img style="width:400px;height: 400px;" src="../images/no score.png" class="img-fluid">
                    </div>
            <?php
                }
            } else {
                $btn_txt = "نمایش کاربران";
                $btn_link = "usercontrol.php?show_user=1";
                $_SESSION['url'] = "index.php";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>