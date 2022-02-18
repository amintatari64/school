<?php 
session_start();
include "../db_info.php";
$db = new mysqli($db_host,$db_username,$db_password,$users_db);
$db -> set_charset("utf8");
if($_SESSION['access'] == "admin" ){
    include "../admin/news.php";
}else{
    include "index.php";
}
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>