<?php
require_once 'conf.php';
session_start();
if (isset($_GET['username'])) {
    $username = $_GET['username'];
  } else {
    $username = $_GET['username'];
  }
  $_SESSION['username'] = $username;
 

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user ID is set in session
if (!isset($_SESSION['username'])) {
    die("User ID not found in session");
}
$username = $_SESSION['username'];
$user_query = "SELECT id FROM user WHERE username = '$username'";
$user_result = mysqli_query($conn, $user_query);
if (!$user_result) {
    die("Error fetching user ID: " . mysqli_error($conn));
}
$user_row = mysqli_fetch_assoc($user_result);
$user_id = $user_row['id'];

if(isset($_POST['update'])) // when click on Update button
{
    $category_name = $_POST['namecat'];
    $receipt = $_POST['receipt'];
    $category_id = $_POST['cat_id'];

    // Update category in category table for given category ID
    $sql = "UPDATE `category` SET `cat_name`='$category_name', `receipt`='$receipt' WHERE `id`='$category_id' AND `user_id`='$user_id'";
    $result = mysqli_query($conn , $sql);
    if (isset($result)) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if category ID is provided in GET parameter
if(isset($_GET['id']))
{
    $category_id = $_GET['id'];

    // Fetch category from category table for given category ID
    $sql = "SELECT * FROM `category` WHERE `id`='$category_id' AND `user_id`='$user_id'";
    $result = mysqli_query($conn , $sql);
    if (isset($result) && mysqli_num_rows($result) == 1) {
        $category_row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: Category not found";
        exit();
    }
}
if(isset($_GET['id']))
{
    $category_id = $_GET['id'];
    $sql = "SELECT * FROM `category` WHERE `id`='$category_id' AND `user_id`='$user_id'";
    $result = mysqli_query($conn , $sql);
    if(mysqli_num_rows($result) == 1) {
        $category_row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: Category not found";
        exit();
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link rel="stylesheet" href="addcategory.css">
</head>
<body>
    <nav>
        <div class="menu">
            <div class="logo">
                <a href="expense.html">EXPENSE TRACKER</a>
            </div>
            <ul>
                <span style="color: white;"><?php echo $username; ?></span>
                <li><a target="_blank" href="expensehome.php">Homepage</a></li>
                <li><a target="_blank" href="login.php">Login</a></li>
                <li><a target="_blank" href="signup.php">Signup</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Add category</a></li>
                <li><a href="#">Reports</a></li>
                <li><a target="_self" href="login.php">Logout</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>
        </div>
    </nav>z
    <form method="POST">
        <div class="container">
            <div class="cat">
                <input type="text" placeholder="CATEGORY NAME" name="namecat" required value="<?php echo $category_row['cat_name']; ?>"/>
                <input type="text" placeholder="RECEIPT" name="receipt" required value="<?php echo $category_row['receipt']; ?>"/>
                <input type="hidden" name="cat_id" value="<?php echo htmlspecialchars($category_id, ENT_QUOTES); ?>"/>
            </div>
            <div class="btn">
                <input type="submit" name="update" value="UPDATE CATEGORY"/>
            </div>
        </div>
    </form>
</body>
</html>
