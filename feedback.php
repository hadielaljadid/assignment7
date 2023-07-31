<?php 
require_once 'conf.php';
$conn = mysqli_connect($host, $user, $pass, $db_name);
session_start();
if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    $username = $_SESSION['username'];
}

if(isset($_POST['submit'])){
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Get the user id based on the username
    $stmt = mysqli_prepare($conn, "SELECT id FROM $users_table WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // Insert the rating and comment data into the database
    $stmt = mysqli_prepare($conn, "INSERT INTO $review_table (rate, comment, user_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isi", $rating, $comment, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the homepage
        header("Location: expensehome.php?username=$username");
        exit();
    } else {
        // Handle the error
        echo "Error: " . mysqli_stmt_error($stmt);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <style>
        body{
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
  }
   /*menu bar*/
nav {
    margin-top: -46%;
    position : fixed;
    background : #1b1b1b;
    width : 100%;
    z-index: 20;
}
nav .menu{
    max-width : 1250px;
    margin : auto;
    display : flex;
    align-items: center;
    justify-content: space-between;
    padding : 0 20px;
}
.menu .logo a{
    font-family: 'poppins', sans-serif;
    text-decoration: none;
    color: #fff;
    font-size: 35px;
    font-weight: 600;
    cursor: pointer;
}
.menu ul{
    display : inline-flex;
}
.menu ul li {
    list-style: none;
    margin-left : 7px;
}
.menu ul li a{
    font-family: 'poppins', sans-serif;
    text-decoration : none;
    color : #fff;
    font-size: 15px;
    font-weight: 500;
   
    padding : 8px 15px;
    border-radius:  5px;
    transition: all 0.3s ease;
}
.menu ul li a:hover{
    background : #fff;
    color : #000;

}

        h1 {
            text-align: center;
            margin-top: 50px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select, textarea {
            width: 90%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        button[type="submit"] {
            background-color: #b2bec3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #636e72;
        }
    </style>
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
         <li><a href="expensehome.php?username=<?php echo $username; ?>">Homepage</a></li>
         <li><a target ="_blank" href ="login.php">Login</a></li>
         <li><a target ="_blank" href="signup.php">Signup</a></li>
         <li><a target ="_self" href="transfer.php?username=<?php echo $username; ?>">Transfer</a></li>
         <li><a target ="_blank" href="addcategory.php?username=<?php echo $username; ?>">add catogry</a></li>
         <li><a target ="_self" href="feedback.php?username=<?php echo $username; ?>">Feedback</a></li>
         <li><a target ="_self" href="logout.php">Logout</a></li>
         <li><a href="edituser.php?username=<?php echo $username; ?>">Edit info</a></li>
        </ul>
   </div>
</nav>

<form method="POST">
    <p>
        <h1>Rate our Website</h1>
        <label for="rating">Rating:</label>
        <select name="rating" id="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </p>
    <p>
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="5" cols="30"></textarea>
    </p>
    <button type="submit" name="submit">Submit</button>
</form>
</body>
</html>