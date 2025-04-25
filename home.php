<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On'); //Displays errors
try { //Tries to login to mariadb and checks if works
    $dsn = "mysql:host=courses;dbname=z2045088";
    $pdo = new PDO($dsn, "z2045088", "2005Jun23");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isset($_POST["cr_uid"]) && isset($_POST["first"]) && isset($_POST["last"]) && isset($_POST["cr_email"]) && isset($_POST["cr_pwd"])
&& isset($_POST["address"]) && isset($_POST["phn"]) && isset($_POST["bill"])) {
    $stmt = $pdo->prepare("INSERT INTO USERS (USERID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ADDRESS, PHONENUM, BILLINFO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['cr_uid'], $_POST['first'],  $_POST['last'],  $_POST['cr_email'],  $_POST['cr_pwd'],  $_POST['address'],  $_POST['phn'],  $_POST['bill']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount()) {
      echo "<h2>Welcome, {$_POST['first']}!</h2>";
      echo "<h2>Click here to go back to signin: </h2>";
      echo "<a href='https://students.cs.niu.edu/~z2045088/accounts.php'>Here</a>";
     }
    else {
      echo "<h2>You failed at least one of the requirements!</h2>";
     }
}
?>
