<?php
include("../db.php");
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
// username and password sent from Form
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password=md5(mysqli_real_escape_string($conn,$_POST['password']));

    $sql = "select * from `users` where (`username` like '%" . $username . "%' or `email` like '%" . $username . "%') and `password` like '%" . $password . "%'";
    $result=mysqli_query($conn,$sql);
    $count=mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);
    if($row['confirm'] == 1 && $count==1)
    {
        $_SESSION['login_id']=$row['user_id'];
        echo $_SESSION['login_id'];
        $log = "UPDATE `users` SET `last_login`=CURRENT_TIMESTAMP WHERE `user_id`=".$_SESSION['login_id'];
        if (mysqli_query($conn,$log) == true){
            echo "success";
        }else{
            echo "failed";
        }
    }

}
?>