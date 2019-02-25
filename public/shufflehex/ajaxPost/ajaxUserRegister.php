<?php
include_once "../db.php";
session_start();

if(isset($_POST['registerNow'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $userName = $_POST['signupUser'];
    $signupEmail = $_POST['signupEmail'];
    $signupPass = $_POST['signupPass'];
    $md5Pass = md5($signupPass);
    $hash = md5(rand(0, 1000));
    $account_status = 0;
    $confirm_status = 0;

    $sql = "INSERT INTO `users`(`username`,`full_name`,`email`,`account_status`,`confirm`,`password`,`hash`) VALUES ('$userName','$full_name','$signupEmail','$account_status','$confirm_status','$md5Pass','$hash')";
    if ((mysqli_query($conn, $sql) == true)) {
        json_encode("Registration Successfull");


        $_SESSION['reg-success'] = '<h5>Thanks !</h5><p>Your account has been created, Verify your Email with the link sent to your inbox.</p>';
        echo '<script>alert("'.$_SESSION['reg-success'].'")</script>';
        $to      = $signupEmail;
        $subject = 'Verify Account';
        $link = '<a style="padding:10px 20px; color: #fff; background: #000" href="http://iamtipu.com/verify-email.php?email='.$signupEmail.'&hash='.$hash.'"></a>';
        $message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

------------------------
Name: '.$full_name.'
Username: '.$userName.'
Enail: '.$signupEmail.'
Password: '.$signupPass.'
------------------------
Please click this button to activate your account:
'.$link.'

'; // Our message above including the link
        $headers = 'From:noreply@dev.iamtipu.com' . "\r\n";
        mail($to, $subject, $message, $headers);
    } else {
        json_encode('Registration Unsuccessfull');
        $_SESSION['reg-success'] = '<h5>Registration Unsuccessfull.</h5><p></p>';
        echo '<script>alert("'.$_SESSION['reg-success'].'")</script>';
    }
}

?>