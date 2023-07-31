<?php 
require_once 'conf.php';
session_start();
$conn = mysqli_connect($host, $user, $pass, $db_name);
if(isset($_POST['registerme']))
{
  $name = $_POST['name'];
  $student_id = $_POST['studentid'];
  $sec = $_POST['section'];
  $amount = $_POST['amount'];
  $cardnumber = $_POST['cardnumber'];
  $cardtype = $_POST['select'];
  $course_id = $_POST['course_id']; 
  
 
  $sql = "SELECT * FROM $subjects_table WHERE id = '$course_id'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) == 0) {

    echo "Invalid course selection";
  } else {
 
    $sql = "INSERT INTO $student_table (`name`, `student_id`, `section`, `amount`, `card_number`, `card_type`, `course_id`) 
    VALUES ('$name', '$student_id', '$sec', '$amount', '$cardnumber', '$cardtype', '$course_id')";
    $result = mysqli_query($conn, $sql);
    $table_id = mysqli_insert_id($conn); 
    $_SESSION['id'] = $table_id; 
    header("location: success.php?id=" . $table_id);
  }
}


$sql = "SELECT * FROM $subjects_table WHERE id IN (1, 2)";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUCATION</title>
</head>
<body>
    <h1>Buy Your Way to a Better Education!</h1>
    <h2>Registration Form</h2> <br>

    <form method="POST">
      <h2> TABLE OF COURSES </h2>
      <table>
        <thead>
          <tr>
            <th>Course</th>
            <th>Course Name</th>
            <th>Instructor Name</th>
            <th>Time</th>
            <th>Checkbox</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['course']; ?></td>
              <td><?php echo $row['course_name']; ?></td>
              <td><?php echo $row['instr_name']; ?></td>
              <td><?php echo $row['time']; ?></td>
              <td><input type="radio" name="course_id" value="<?php echo $row['id']; ?>"></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      
      <br>

      NAME : <br>
      <input type="text" placeholder="Enter your name" name="name" required> <br>
      STUDENT ID : <br>
      <input type="text" placeholder="Enter your id" name="studentid" required> <br>
      SECTION : <br>
      <input type="text" placeholder="Enter your section" name="section" required><br>
      AMOUNT : <br>
      <input type="text" placeholder="Enter amount" name="amount" required><br>
      CARD NUMBER : <br>
      <input type="text" placeholder="Enter your card number" name="cardnumber" required><br>
      <p>
        <input type="radio" id="Student Card" name="select" value="Student Card">
        <label for="Student Card">Student Card</label>
        <input type="radio" id="Visa" name="select" value="Visa">
        <label for="Visa">Visa</label>
        <input type="radio" id="MasterCard" name="select" value="MasterCard">
        <label for="MasterCard">MasterCard</label> 
      </p>
      <p>
        <input type="submit" value="Register" name="registerme">
      </p>
    </form>
</body>
</html>