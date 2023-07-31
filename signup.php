<?php
require_once 'conf.php';
session_start();
$unique_code = '?';
$conn = mysqli_connect($host, $user, $pass ,$db_name);
if(isset($_POST['signup']))
{
  $name = $_POST['username'];
  $email = $_POST['email'];
  $fullname = $_POST['fullname'];
  $phon = $_POST['phonenumber'];
  $password = $_POST['Password'];
  $cpassword = $_POST['cPassword'];
  /*
  if(mysqli_connect_errno()){
    echo "not connected";
    exit(); 
  }
  else {
    echo "connected";
  }*/
  $sql = "INSERT INTO `user`(`username`, `email`, `fullname`, `phonenumber`, `pswrd`) VALUES ('$name','$email','$fullname', '$phon', '$password')";
  $user_id = $_SESSION ['id'];
  $result = mysqli_query($conn , $sql);
  header("location:login.php?id=". $user_id);

  if(strlen($password) >=14 ) {
      $error[] =  "password exceeded the required limit ";
  }

  else 
      {
      if( strpos($password, $unique_code) == false) {
          $error[] = "The password does not contain a unique code ";
      }
      else
       {
        if($password != $cpassword) {
            $error[] = "Password not matched.";
        }
            
            }
         }
        }
    


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>SIGN UP</title>  
      <nav>
        <div class = "menu">
        <div class = "logo">
         <a href="#">EXPENSE TRACKER</a>
          </div>
            <ul>
              <li><a target="_blank" href="expense.html">Homepage</a></li>
              <li><a target ="_blank" href ="login.php">Login</a></li>
              <li><a target ="_self" href="signup.php">Signup</a></li>
              <li><a href="#">About us</a></li>
              <li><a target ="_blank" href="category.html">Add category</a></li>
              <li><a href="#">Reports</a></li>
              <li><a href="#">Logout</a></li>
              <li><a target ="_blank" href ="login.php">Feedback</a></li>
             </ul>
         </div>
         </nav>
</head>
<body>
    <div class="container">
        <div class="title">Registration</div>
        <?php
        if(isset($error)){
          foreach($error as $error){
            echo '<span class = "error-msg">' . $error. '</span>';
          };
        };

        ?>
        <div class="content">
          <form action="#"method = "POST">
            <div class="user-details"> 
              <div class="input-box">
                <span class="details">Full Name</span>
                <input type="text" placeholder="Enter your name" name = 'fullname' required>
              </div>
              <div class="input-box">
                <span class="details">Username</span>
                <input type="text" placeholder="Enter your username" name = 'username' required>
              </div>
              <div class="input-box">
                <span class="details">Email</span>
                <input type="text" placeholder="Enter your email" name = 'email' required>
              </div>
              <div class="input-box">
                <span class="details">Phone Number</span>
                <input type="number" placeholder="Enter your number"name = 'phonenumber' required>
              </div>
              <div class="input-box">
                <span class="details">Password</span>
                <input type="text" placeholder="Enter your password"name = 'Password' required>
              </div>
              <div class="input-box">
                <span class="details">Confirm Password</span>
                <input type="text" placeholder="Confirm your password"name = 'cPassword' required>
              </div>
            </div>
            <div class="button">
              <input type="submit" value="Register"name = 'signup'>
            </div>
          </form>
        </div>
      </div>
</body>
</html>