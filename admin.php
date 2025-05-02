<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaTech Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            background-color: #CCFFFF;
        }
        h1 {
            font-family: 'Arial', Verdana, sans-serif;
            color: #003366;
            font-size: 48px;
            margin-bottom: 20px;
        }
        a.button-link {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 12px 24px;
            border-radius: 6px;
            display: block;
            margin: 20px auto;
            width: 220px;
            font-size: 18px;
        }
        a.button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
  <h1>NovaTech Admin</h1>
  <?php
    session_start(); // Start session
    $acode = '8042'; //Passcode for admin
    if (isset($_GET['logout'])) { // Handle logout
      session_destroy();
      header('Location: admin.php');
      exit;
    }
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { // User is logged in and shows admin links
      echo"<a href='inventory.php' class='button-link'>View Inventory</a>";
      echo"<a href='orders.php' class='button-link'>View Orders</a>";
      echo"<a href='admin.php?logout=1' class='button-link'>Logout</a>";
    }
    else { // Sees if the passcode is right
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code'])) {
         $code = $_POST['code'];
         if ($code == $acode) {
           $_SESSION['is_admin'] = true;
           header('Location: admin.php');
           exit;
         }
         else {
           echo "Incorrect code. Please try again.";
           echo"<a href='admin.php' class='button-link'>Back</a>";
         }
      }
      else { // form that asks the admin code
        echo"<form method='post' action=''>";
        echo"<label for='code'>Enter admin code:</label>";
        echo"<input type='password' id='code' name='code' required />";
        echo"<button type='submit'>Login</button>";
        echo"</form>";
        echo"<a href='homepage.php' class='button-link'>Back</a>";
      }
    }
?>
</body>
</html>
