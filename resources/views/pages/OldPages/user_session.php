<?php
$user_id = $_SESSION['login_id'];
$sql = "select * from `users` WHERE `user_id`='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$username = $row['username'];
$fullName = $row['full_name'];
$email = $row['email'];
$last_login = $row['last_login'];
$joined = $row['joined'];

$user_data =array();
$user_data[]=$row;