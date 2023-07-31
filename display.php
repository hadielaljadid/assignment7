<!-- hadiel aljadid /// this is the display page -->
<?php 
session_start();
$username = $_SESSION['username']; //getting the username to get the id afterwards

require_once 'conf.php';
$conn = mysqli_connect($host, $user, $pass ,$db_name);
if ($conn->connect_error) {
    echo '<p>Error: Could not connect to database.<br/>
    Please try again later.<br/></p>';
    echo $conn->error;
    exit;
}
$user_query = "SELECT id FROM user WHERE username = '$username'"; //fetch id
$user_result = mysqli_query($conn, $user_query);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="expense.css">
    <title>Display all categories from Database</title>
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
            <li><a target ="_blank" href="transfer.php?username=<?php echo $username; ?>">Transfer</a></li>
            <li><a href="addcategory.php">Add category</a></li>
            <li><a target ="_self" href="feedback.php?username=<?php echo $username; ?>">Feedback</a></li> 
            <li><a target="_self" href="login.php">Logout</a></li>
            <li><a href="edituser.php?username=<?php echo $username; ?>">Edit info</a></td>
        </ul>
    </div>
</nav>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin: auto;
        font-family: Arial, sans-serif;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    a {
        color: #333;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    body{
        background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
    }
    input[type="submit"] {
        background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
        margin: auto;
        color: #fff;
        border: none;
        padding: 11px 40px;
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

<div class="container" style="padding-top: 200px;">
    <form action="#" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Category name</th>
                <th>Receipt</th>
                <th>Edit</th>
            </tr>

            <?php
            $sql = "SELECT `id`, `cat_name`, `receipt` FROM  `category` WHERE `user_id` = (SELECT id FROM user WHERE username = '$username')";
            ///$category_id = "SELECT id FROM `category` WHERE `cat_name` = '$data['cat_name']' ";
            $result = $conn->query($sql);
            if (!$result) {
                echo "<p>Unable to execute the query.</p> ";
                echo $query;
                die($conn->error);
            }
            while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
              ///$category_id =$data['cat_name'];
                ?>
                <tr>
                    <td>
                        <?php echo $data['cat_name']; ?>
                    </td>
                    <td>
                        <?php echo $data['receipt']; ?>
                    </td>
                    <td><a href="edit.php?cat_name=<?php echo $data['cat_name']; ?>">Edit</a></td>
                    <td> <a href="expensetable.php?id=<?php echo $data['id']; ?>&username=<?php echo $username;?> " >ADD EXPENSE</a> </td> 
                </tr>
                <?php
            }
            ?>
        </table>
    </form>
   
</div>
</body>
</html>