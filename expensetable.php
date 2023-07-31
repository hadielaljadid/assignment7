<?php
require_once 'conf.php';
$mysqli = new mysqli($host, $user, $pass, $db_name);
session_start();
$category_id = $_GET['id'];
$username = $_GET['username'];
//$select = mysqli_query($mysqli,"SELECT * FROM  $cat_table WHERE id = '$category_id' " );
//$row = mysqli_fetch_array($select);
//if(is_array($row)){
 // $_SESSION['amount'] = $row['amount'];
  //$_SESSION[''] =
  //$_SESSION =
 // $_SESSION =
//}
if (!isset($_SESSION['receipt'])) {
  echo "not found";
}





if (isset($_GET['id'])) {
  $category_id = $_GET['id'];
} else {
  throw new InvalidArgumentException('Category ID not found in URL');
}
try {

} catch (InvalidArgumentException $e) {
  echo 'Error: ' . $e->getMessage();

}
try{
$mysqli->begin_transaction();
if ($mysqli->connect_error)
 {
 die("Fatal Error");
 }

if (isset($_POST['addExpense']))
 {
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $comments = $_POST['comments'];
    $paymentMethod = $_POST['payment-method'];
    $category_id = $_GET['id']; 
    
    $sql = "SELECT * FROM $cat_table WHERE id = '$category_id'";

    $result = $mysqli->query($sql);  
   if ($result->num_rows > 0) {
     $value = mysqli_fetch_assoc($result);
     if ($value['id'] === $category_id) 
     {
          $_SESSION['receipt']=$value['receipt'];
        }
      }
        if ($category_id ===  $_GET['id'] )
        {
          if ($amount <= $_SESSION['receipt']) 
          {
            $category_id = $_GET['id']; 
           
            $sql = "INSERT INTO expenses (date, amount, comment, payment, cat_id) VALUES ('$date','$amount', '$comments', '$paymentMethod', '$category_id')";
            $stmt = $mysqli->query($sql);
            $sql ="UPDATE $cat_table SET receipt=receipt-$amount WHERE id=$category_id";
            $stmt = $mysqli->query($sql);
            $mysqli->commit();
          }
        }
       else {
        echo "Category not found or amount is not enough";
       }
  
      }
    }
    catch (mysqli_sql_exception $exception) {
      echo 'Transaction Failed!!';
  }
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Expenses</title>
  
  <nav>
    <div class="menu">
        <div class="logo">
            <a href="expense.html">EXPENSE TRACKER</a>
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
  <style>
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
    body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.4;
      color: #333;
      background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    h1, h2 {
      font-size: 36px;
      font-weight: bold;
      margin-top: 0;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    label {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    input[type="date"],
    input[type="number"],
    textarea,
    select {
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
      width: 100%;
    }

    button[type="submit"] {
      background: linear-gradient(to left, #b2bec3 0%, #636e72 100%);
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
    }

    button[type="submit"]:hover {
        background-color: #3e8e41;
        transform: scale(1.05);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      vertical-align: top;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f8f8f8;
      font-weight: bold;
    }

    tr:hover {
      background-color: #f8f8f8;
    }
  </style>
</head>
<body>

  <div class="container">
<br><br><br>
      <h2>Add Expense</h2>
      <form method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>

        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments"></textarea>

        <label for="payment-method">Payment Method:</label>
        <select id="payment-method" name="payment-method">
          <option value="check">Check</option>
          <option value="card">Credit Card</option>
          <option value="Debit Card">Debit Card</option>
          <option value="cash">Cash</option>
        </select>

        <button type="submit" name="addExpense">Add Expense</button>
        
      </form>
      <a href='search.php?username=<?php echo $username;?>&category_id=<?php echo $category_id; ?>'>Search</a>
      
    <h2>DISPLAY ALL EXPENSES</h2>
   <div class = container>
   <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Amount</th>
      <th>Comments</th>
      <th>Payment Method</th>
      <th>Category</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $sql = "SELECT expenses.id, expenses.date, expenses.amount, expenses.comment, expenses.payment, category.cat_name FROM expenses INNER JOIN category ON expenses.cat_id = category.id";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['date']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['comment']}</td>
                <td>{$row['payment']}</td>
                <td>{$row['cat_name']}</td>
               
                <td><a href='editexp.php?id=" . $row['id'] . "&username=" . $username . "'>Edit</a></td>
                <td><a href='deleteExpense.php?id=" . $row['id'] . "&username=" . $username . "' onclick='return confirm(\"Are you sure you want to delete this expense?\")'>Delete</a></td>
              </tr>";
      }
    } else {
      echo '<tr><td colspan="7">No expenses found</td></tr>';
    }

    mysqli_close($mysqli);
    ?>
  </tbody>
</table>
</div>
</body>
</html>