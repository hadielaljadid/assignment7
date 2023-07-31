<?php 
require_once 'conf.php';
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Start the transaction
mysqli_begin_transaction($conn);

session_start();
if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    $username = $_SESSION['username'];
}

/////////////////////////////////////////////////
$sql = "SELECT id FROM $users_table WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    // Handle the error and rollback the transaction
    mysqli_rollback($conn);
    die("Error retrieving user ID: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$user_id = $row['id'];
//////////////////////////////////////////////////

// Get the list of categories for the dropdown menus
$sql = "SELECT cat_name FROM $cat_table WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    // Handle the error and rollback the transaction
    mysqli_rollback($conn);
    die("Error retrieving categories: " . mysqli_error($conn));
}
$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['cat_name'];
}
if(isset($_POST['TRANSFER'])){
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $comment = $_POST['comment'];
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Check if the transfer is possible
    $sql = "SELECT receipt FROM $cat_table WHERE cat_name = '$from' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $from_balance = $row['receipt'];
    if ($from_balance < $amount) {
        $error_message = "Error: Insufficient balance in source category";
    } else {
        // Perform the transfer
        $from_balance -= $amount;
        $sql = "UPDATE $cat_table SET receipt = $from_balance WHERE cat_name = '$from' AND user_id = '$user_id'";
        mysqli_query($conn, $sql);

        $sql = "SELECT id FROM $cat_table WHERE cat_name = '$to' AND user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $to_id = $row['id'];
        $sql = "SELECT receipt FROM $cat_table WHERE id ='$to_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $to_balance = $row['receipt'];
        $to_balance += $amount;
        $sql = "UPDATE $cat_table SET receipt = $to_balance WHERE id = '$to_id' AND user_id = '$user_id'";
        mysqli_query($conn, $sql);

        // Insert the transfer data into the database table
        $sql = "INSERT INTO $transfer_tabel (CategoryId_1, CategoryId_2, amount, comment, Date) 
                VALUES ((SELECT id FROM $cat_table WHERE cat_name='$from' AND user_id='$user_id'),
                        (SELECT id FROM $cat_table WHERE cat_name='$to' AND user_id='$user_id'),
                        '$amount', '$comment', '$date')";

        if (mysqli_query($conn, $sql)) {
            // Commit the transaction
            mysqli_commit($conn);
            // Redirect to the homepage
            header("Location: expensehome.php?username=$username");
            exit();
        } else {
            // Handle the error and rollback the transaction
            mysqli_rollback($conn);
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer money</title>
    <link rel="stylesheet" href="transfer.css">
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
<div class="container">
    <form method="POST">
        <label for="amount">Transfer Amount</label>
        <input type="number" id="amount" name="amount" required>
        <br>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>
        <br>
        <label for="comment">Comment</label>
        <input type="text" id="comment" name="comment">
        <br>
        <label for="from">From Category</label>
        <select id="from" name="from" required>
            <option value="" >Select a category</option>
            <?php
            foreach ($categories as $category) {
                echo "<option value=\"$category\">$category</option>";
            }
            ?>
        </select>
        <br>
        <label for="to">To Category</label>
        <select id="to" name="to" required>
            <option value="" >Select a category</option>
            <?php
            foreach ($categories as $category) {
                echo "<option value=\"$category\">$category</option>";
            }
            ?>
        </select>
        <br>
        <button type="submit" name="TRANSFER">Transfer</button>
        <?php
        if (isset($error_message)) {
            echo "<p class=\"error-message\">$error_message</p>";
        }
        ?>
    </form>
</div>
</body>
</html>