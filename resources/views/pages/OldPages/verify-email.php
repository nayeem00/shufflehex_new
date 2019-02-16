<?php
include_once "db.php";
session_start();
$email = $_GET['email'];
$hash = $_GET['hash'];
if(isset($email) && !empty($email) AND isset($hash) && !empty($hash)){
    $email = mysqli_real_escape_string($conn,$_GET['email']); // Set email variable
    $hash = mysqli_real_escape_string($conn,$_GET['hash']); // Set hash variable

    $search = mysqli_query($conn,"SELECT `email`, `hash`, `confirm`,`account_status` FROM `users` WHERE `email`='".$email."' AND `hash`='".$hash."'") or die();
    $match  = mysqli_num_rows($search);
    $row  = mysqli_fetch_assoc($search);
    $status = $row['account_status'];
    $confirm = $row['confirm'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Suffle Case</title>
        <?php include 'assets.blade.php';?>

    </head>
    <body>
    <div id="main-page">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="reg-status text-center m-auto">
                    <?php
                    if ($match == 1 && $confirm == 0){
                        $confirm = mysqli_query($conn,"UPDATE `users` SET `confirm`='1' WHERE `email`='".$email."' AND `hash`='".$hash."'");
                        if ($confirm == true){
                            echo '<h5 class="alert alert-success animated fadeIn">Email Verified Successfully</h5>';
                        }
                    }elseif($match == 1 && $confirm == 1){
                        echo '<h5 class="alert alert-success animated fadeIn">Email Already Verified.</h5>';
                    }else{
                        echo '<p class="text-danger">There is a problem to verify your email.</p>';
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php } ?>