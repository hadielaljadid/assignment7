<?php
session_start();
if (isset($_GET['username'])) {
    $username = $_GET['username'];
  } else {
    $username = $_GET['username'];
  }
  $_SESSION['username'] = $username;
 
require_once 'conf.php';
$conn = mysqli_connect($host, $user, $pass ,$db_name);
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit(); 
}
$username = $_SESSION['username'];
$user_query = "SELECT id FROM user WHERE username = '$username'";
$user_result = mysqli_query($conn, $user_query);
if (!$user_result) {
    die("Error fetching user ID: " . mysqli_error($conn));
}
if(isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $sql = "UPDATE `user` SET `fullname`='$fullname', `username`='$username', `email`='$email', `phonenumber`='$phonenumber' WHERE `username`='$username'";
    $result = mysqli_query($conn , $sql);
    if($result) {
        echo "User updated successfully";
       // header("Location: expensehome.php");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit user info</title>
</head>
<body>
<div class="content">
  <form action="#" method="POST">
    <div class="user-details"> 
      <div class="input-box">
        <span class="details">Full Name</span>
        <input type="text" name="fullname" placeholder="fullname" required>
      </div>
      <div class="input-box">
        <span class="details">Username</span>
        <input type="text" name="username" placeholder="username" required>
      </div>
      <div class="input-box">
        <span class="details">Email</span>
        <input type="text" name="email" placeholder="email" required>
      </div>
      <div class="input-box">
        <span class="details">Phone Number</span>
        <input type="number" name="phonenumber" placeholder="phonenumber" required>
      </div>
    </div>
    <div class="button">
      <input type="submit" name="update" value="Update">
    </div>
  </form>
</div>
</body>
</html>