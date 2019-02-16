<?php
include_once '../db.php';

if ($_POST){
    $title = mysqli_real_escape_string($conn,$_POST['storyTitle']);
    $url = mysqli_real_escape_string($conn,$_POST['storyLink']);
    $category = mysqli_real_escape_string($conn,$_POST['storyCategory']);
    $desc = mysqli_real_escape_string($conn,$_POST['storyDesc']);

    $sql = "INSERT INTO `links`(`title`, `url`, `desc`,`cat_id`) VALUES ('$title','$url','$desc','$category')";
    if (mysqli_query($conn,$sql)){
        echo "link submited Successfully";
    }else{
        echo "link submition Failed";
    }
}