<?php
include "db.php";
session_start();
if (isset($_SESSION['login_id'])){
    include "user_session.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>
    <link rel="stylesheet/less" type="text/css" href="less/home.less">
    <?php include "assets.blade.php";?>
    <style>
    </style>
</head>
<body>
<div class="se-pre-con">
    <div class="loader"></div>
</div>
<div id="wrapper">
    <?php include "topbar.blade.php";?>
    <div id="home-body" class="">
        <div class="suffle text-center">
            <button type="button" id="suffle-btn" class="btn btn-lg btn-danger">
                Shuffle
            </button>
        </div>
        <?php
        ?>
    </div>
    <footer id="footer" class=" text-center" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
<?php include "sidebar.blade.php";?>
</body>
</html>