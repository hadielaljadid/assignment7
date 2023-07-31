<?php 
require_once 'conf.php';
$conn = mysqli_connect($host, $user, $pass, $db_name);
$username = $_GET['username'];
$category_id = $_GET['category_id'];

function displayExpenses($conn)
{
    $category_id = $_GET['category_id'];
    $sql = 'SELECT expenses.date, expenses.amount, expenses.comment, expenses.payment, category.cat_name FROM expenses INNER JOIN category ON expenses.cat_id = category.id ';
    if (isset($_POST['search'])) {
        $startDate = $_POST['start-date'];
        $endDate = $_POST['end-date'];
        if ($startDate && $endDate) {
            $sql .= " WHERE expenses.date BETWEEN '$startDate' AND '$endDate'"; // Search by date
        }
        if ($category_id) {
            $sql .= " AND expenses.cat_id = $category_id"; // Filter by category ID
        }
    }
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
              <td>{$row['date']}</td>
              <td>{$row['amount']}</td>
              <td>{$row['comment']}</td>
              <td>{$row['payment']}</td>
              <td>{$row['cat_name']}</td> 
            </tr>";
        }
    } else {
        echo '<tr><td colspan="5">No expenses found</td></tr>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Expenses</title>
    <style>
        /* Add styles for the navigation menu */
        nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: black;
  padding: 5px;
}

.menu {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1290px;
  margin: 0 auto;
}

.menu .logo a {
  font-family: 'Poppins', sans-serif;
  text-decoration: none;
  color: #fff;
  font-size: 35px;
  font-weight: 700;
  cursor: pointer;
}

.menu ul {
  display: flex;
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
}

.menu ul li {
  margin-left: 7px;
}

.menu ul li a {
  font-family: 'Poppins', sans-serif;
  text-decoration: none;
  color: #fff;
  font-size: 15px;
  font-weight: 500;
  padding: 8px 15px;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.menu ul li a:hover {
  background: #fff;
  color: #000;
}

body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.4;
  color: #333;
  background: linear-gradient(to right, #b2bec3 0%, #636e72 100%);
}

.container {
  max-width: 600px;
  margin: 0 auto;
}

h1,
h2 {
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

input[type='date'],
input[type='number'],
textarea,
select {
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
  width: 100%;
}

button[type='submit'] {
  background: linear-gradient(to left, #b2bec3 0%, #636e72 100%);
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

button[type='submit']:hover {
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
                <li><a target="_self" href="logout.php">Logout</a></li>
                <li><a href="edituser.php?username=<?php echo $username; ?>">Edit info</a></td>
            </ul>
        </div>
    </nav>
    <h1>Search Expenses by date</h1>
    <div class="expenses">
      <form method="POST">
        <label for="start-date">Start Date:</label>
        <input type="date" name="start-date" id="start-date">
        <label for="end-date">End Date:</label>
        <input type="date" name="end-date" id="end-date">
        <button type="submit" name="search">Search</button>
      </form>
    </div>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Amount</th>
          <th>Comments</th>
          <th>Payment Method</th>
          <th>Category Name</th>
        </tr>
      </thead>
      <tbody>
        <?php displayExpenses($conn, $category_id); ?>
      </tbody>
    </table>
</body>
</html>