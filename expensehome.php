<?php
session_start();
 if (isset($_GET['username'])) {
   $username = $_GET['username'];
 } else {
   $username = $_GET['username'];
 }
 $_SESSION['username'] = $username;

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPENSE TRACKER</title>
    <link rel="stylesheet" href="expensehome.css">
</head>
<body>
    <nav>
   <div class = "menu">
   <div class = "logo">
    <a href="#">EXPENSE TRACKER</a>
     </div>
       <ul>
        <?php
       echo '<span style="color: white;">' . $username . '</span>';
        ?>
         <li><a href="#">Homepage</a></li>
         <li><a target ="_blank" href ="login.php">Login</a></li>
         <li><a target ="_blank" href="signup.php">Signup</a></li>
         <li><a target ="_blank" href="transfer.php?username=<?php echo $username; ?>">Transfer</a></li>
         <li><a target ="_blank" href="addcategory.php?username=<?php echo $username; ?>">add catogry</a>
         <li><a target ="_blank" href="feedback.php?username=<?php echo $username; ?>">Feedback</a></li>
         <li><a target ="_self" href="logout.php">Logout</a></li>
         <li><a href="edituser.php?username=<?php echo $username; ?>">Edit info</a></li>
        </ul>
    </div>
    </nav>
    <div class="img"></div>
    <div class="center">
    <div class="title">WELCOME
        </div>
    <div class="sub_title">
        An expense tracker website<br>
        is a platform that allows users <br>
        to track and manage their financial<br>
        transactions and monitor their spending.</div>
       
</body></div>
</html>