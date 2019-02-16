<?php
require '../root.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>Profile</title>
    
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet/less" href="../less/style.less">
    <link rel="stylesheet/less" href="../less/profile.less">
    <link rel="stylesheet/less" href="../less/sidebar.less">
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
</head>
<body>
<?php
include '../template-parts/list-small-window-sidebar.php';
?>
<div id="wrapper">
    <?php
    include '../template-parts/top-bar.php';
    ?>
    <div id="body-content">
        <div class="user-profile-content container-fluid">
            <div class="row">
                <div class="profile-header text-center">
                    <div class="profile-header-bg"></div>
                    <div class="profile-img text-center">
                        <img src="https://i.pinimg.com/736x/7f/79/6d/7f796d57218d9cd81a92d9e6e8e51ce4--free-avatars-online-profile.jpg">
                    </div>
                    <div class="user-short-info">
                        <h1>Name</h1>
                        <h3>username</h3>
                        <p class="karma">Karma 20</p>
                    </div>
                    <div class="user-social-icon">
                        <a href=""><i class="fa fa-facebook-square"></i></a>
                        <a href=""><i class="fa fa-linkedin-square"></i></a>
                        <a href=""><i class="fa fa-twitter"></i></a>
                        <a href=""><i class="fa fa-google-plus"></i></a>
                        <a href=""><i class="fa fa-globe"></i></a>
                    </div>
                
                </div>
            
            </div>
        </div>
    </div>
    
    <div class="overlay"></div>
</div>






<!-- jQuery CDN -->
<!--         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script src="../js/home.js"></script>


</body>
</html>
