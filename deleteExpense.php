<?php
require_once 'conf.php';
$username = $_GET['username'];
$conn = mysqli_connect($host, $user, $pass, $db_name);
$id = $_GET['id'];// get id through query string
$query = "SELECT `cat_id`, `amount`, `comment`, `date`, `payment` FROM $expense_table WHERE id = '$id'"; // select query
$result = mysqli_query($conn, $query);

if (!$result) 
{
    echo "<p>Unable to execute the query.</p> ";
    echo $query;
    die ($conn -> error);
}
$data = mysqli_fetch_assoc($result);
if(isset($_POST['delete'])) // when click on Update button
{
 $query ="Delete from expenses where id='$id'";
 $delete =  mysqli_query($conn, $query);
 if($delete)
    {
        $conn->close();// Close connection
        header("location:display.php"); // redirects to all records page
        exit;
    }
    else
    {
        echo "<p>Unable to execute the query.</p> ";
        echo $query;
        die ($conn -> error);
    }    	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Expense</title>
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
            <li><a href="addcategory.php">Add category</a></li>
            <li><a href="#">Reports</a></li> 
            <li><a target="_self" href="login.php">Logout</a></li>
            <li><a href="edituser.php?username=<?php echo $username; ?>">Edit info</a></td>
        </ul>
    </div>
</nav>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
}
    nav {
    margin-top: -1%;
    display : block;
    background : #1b1b1b;
    width : 90%;
    padding : 0px 80px;
  }
  nav .menu{
    max-width : 1290px;
    margin : auto;
    display : flex;
    align-items: center;
    justify-content: space-between;
    padding : 0 30px;
  }
  .menu .logo a{
    font-family: 'poppins', sans-serif;
    text-decoration: none;
    color: #fff;
    font-size: 35px;
    font-weight: 700;
    cursor: pointer;
  }
  .menu ul{
    font-family: 'poppins', sans-serif;
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
        h3 {
            color: #333;
            text-align: center;
            margin-top: 130px;
        }
        form {
            margin: 40px auto;
            max-width: 600px;
            background-color: #FFF;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 20px;
            font-size: 16px;
            background-color: #F5F5F5;
            color: #333;
        }
        input[type="submit"] {
            background-color: #FF4136;
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #D32F2F;
        }
    </style>
</head>
<body>

<h3>Delete Expense</h3>
<form method="POST">

  <input type="text" name="date" value="<?php echo $data['date'] ?>"  disabled><br><br>
  <input type="text" name="amount" value="<?php echo $data['amount'] ?>" min="0" step="0.01"disabled><br><br>
  <input type="text" name="comment" value="<?php echo $data['comment'] ?>" disabled><br><br>

  <input type="submit" name="delete" value="Delete">
</form>
</div>
</body>
</html>