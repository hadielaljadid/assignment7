<?php
require_once 'conf.php';
// Create connection
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
// Check if user ID is set in session
if (!isset($_SESSION['username'])) {
    die("User ID not found in session");
}

// Fetch user ID from users_table
$username = $_SESSION['username'];
$user_query = "SELECT id FROM user WHERE username = '$username'";
$user_result = mysqli_query($conn, $user_query);
if (!$user_result) {
    die("Error fetching user ID: " . mysqli_error($conn));
}
$user_row = mysqli_fetch_assoc($user_result);
$user_id = $user_row['id'];

// Check if form is submitted
if(isset($_POST['ADD']))
{
    $category_name = $_POST['namecat'];
    $receipt = $_POST['receipt'];

    // Insert category into category table
    $sql = "INSERT INTO `category`(`cat_name`, `user_id`, `receipt`) VALUES ('$category_name','$user_id','$receipt')";
    $result = mysqli_query($conn , $sql);
    if (isset($result)) {
        $_SESSION['username'] = $username;
        $_SESSION['cat_name'] = $category_name;
        $category_id = mysqli_insert_id($conn); // الحصول على الـ ID الخاص بالفئة الجديدة
        $url = "display.php?username=$username&category=$category_name&id=".urlencode($category_id); // إنشاء الرابط الجديد مع الـ ID الخاص بالفئة
        header("Location: $url"); // إعادة توجيه المستخدم إلى الصفحة المناسبة
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD CATEGORY</title>
    <link rel="stylesheet" href="addcategory.css">
</head>
<body>

<nav>
    <div class="menu">
        <div class="logo">
            <a href="expense.html">EXPENSE TRACKER</a>
        </div>
        <ul>
            <?php
            echo '<span style="color: white;">' . $username . '</span>';
            ?>
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
</nav>
<style>
    
body{
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
  }
  .container{
   
   width: 100%;
   background-color: #fff;
   padding: 50px 50px;
   border-radius: 10px;
   box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
.container .cat {
   
   display: flex;
   font-family: 'poppins', sans-serif;
   justify-content: space-between;
   margin: 50px 0 70px 0;
   height: 50px;
   border-radius: 5px;
   border: 1px solid #ccc;
   transition: all 0.3s ease;
}
   .btn {
    font-family: 'poppins', sans-serif;
    background: linear-gradient(to left, #b2bec3 0%, #636e72 100%);
    margin: 20px 0 15px 0;
    display: block;
    height: 45px;
    width: 100%;
    font-size: 15px;
    text-decoration: none;
    padding-left: 20px;
    line-height: 45px;
    color: #fff;
    border-radius: 5px;
    transition: all 0.3s ease;  
     cursor: pointer; 
     border: none; 
     letter-spacing: 1px;
}


input[type="submit"] {
    background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
    color: #fff;
    border: none;
    padding: 10px 30px;
    font-size: 17px;
    border-radius: 5px;
    display: flex;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    text-decoration: none;
}

input[type="submit"]:hover, a.btn:hover {
    background-color: #3e8e41;
    transform: scale(1.05);
}
</style>
<form method="POST"> 
    <div class="container"> 
        <div class="cat">
            <input type="text" placeholder="CATEGORY NAME" name="namecat" required />
            <input type="text" placeholder="RECEIPT" name="receipt" required>
        </div>
        <div class="btn">
            <input type="submit" name="ADD" value="ADD CATEGORY">
            <a href="display.php?username=<?php echo $username; ?>"class="btn">DISPLAY CATEGORIES</a> </div> </form> </div> </body> </html>
        </div>
    </div>
</form>
</body>
</html>