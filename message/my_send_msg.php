<?php 
    $code = $_SESSION['code'];
    $query = "SELECT * FROM message WHERE send_code='$code'";
    $result = $db->query($query);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $query2 = "SELECT * FROM info WHERE code='".$row['receiv_code']."'";
                    $result2 = $db->query($query2);
                    while($row2 = $result2->fetch_assoc()) {
                        ?>
                        <div class="col-12 mb-2 border rounded-3 shadow-sm bg-primary bg-opacity-10 p-4">
                         <p class="fs-3">ارسال شده به : <?php echo $row2['fname']. " " . $row2['lname']; ?></p>
                         <p class="pt-4"><?php echo $row['txt']; ?></p>
                         <p class="mt-5">خوانده شده : <?php echo $row['ifread']; ?></p>
                         <button type="button" class="btn btn-outline-danger mt-1 rounded p-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#delete">حذف این پیام</button>
                        </div>
                        <?php
                        $_SESSION['delete_msg_id'] =$row['id'];
                        $_SESSION['delete_msg_fname'] =$row2['fname'];
                        $_SESSION['delete_msg_lname'] =$row2['lname'];
                    }
                }
            }else{
                ?>
               <div class="container-sm text-center">
                  <p class=" text-danger fs-2">هیچ پیامی وجود ندارد!</p>
                  <img style="width:400px;height: 400px;" src="../images/no score.png" class="img-fluid">
               </div>
               <?php
            }
    ?>