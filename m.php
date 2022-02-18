<?php 
include "db_info.php";
$db = mysqli_connect($db_host,$db_username,$db_password,$users_db);
// $query = $sql = "CREATE TABLE news (
 //   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 //   send_code INT(12) NOT NULL,
 //   receive VARCHAR(30) NOT NULL,
 //   title VARCHAR(50) NOT NULL,
 //   txt VARCHAR(500) NOT NULL,
 //   date VARCHAR(20) NOT NULL
 //   )";
//mysqli_query($db,$query);

?>