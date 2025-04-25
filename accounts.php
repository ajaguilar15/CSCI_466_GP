<html>
  <body>
    <h1>Welcome to our Best Buy Store</h1>
    <h2>Do you want to sign in or create your own account?</h2>
    <?php
      $goto = "https://students.cs.niu.edu/~z2045088/products.php";
      $dsn = "mysql:host=courses;dbname=z2045088";
      $pdo = new PDO($dsn, "z2045088", "2005Jun23");
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        switch ($action) {
          case 'signin': 
            if (isset($_POST['email']) && isset($_POST['pwd'])) {
              $stmt = $pdo->prepare("SELECT * FROM USERS WHERE EMAIL = ? AND PASSWORD = ?");
              $stmt->execute([$_POST['email'], $_POST['pwd']]);
              $user = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($user) {
                echo "<h2>Welcome back, {$user['FIRST_NAME']}!</h2>";
              }
              else {
                echo "<h2>Invalid email or password!</h2>";
              }
            }
            else {
              echo "<h2>Type in your Email and Password</h2>";
              echo "<form method='POST' action='$goto'>";
              echo "<input type='hidden' name='action' value='signin'>";
              echo "<label for='email'>Email:</label><br>";
              echo "<input type='text' name='email' id='email' required><br><br>";
              echo "<label for='pwd'>Password:</label><br>";
              echo "<input type='password' name='pwd' id='pwd' required><br><br>";
              echo "<input type='submit' value='Submit'>";
              echo "</form>";
            }
            break;
          case 'create_account':
            echo "<h2>Create Your Account</h2>";
            echo "<form method='POST' action='home.php'>";
            echo "<label for='cr_uid'>UserID:</label><br>";
            echo "<input type='text' name='cr_uid' id='cr_uid'><br><br>";
            echo "<label for='first'>First Name:</label><br>";
            echo "<input type='text' name='first' id='first'><br><br>";
            echo "<label for='last'>Last Name:</label><br>";
            echo "<input type='text' name='last' id='last'><br><br>";
            echo "<label for='cr_email'>Email:</label><br>";
            echo "<input type='text' name='cr_email' id='cr_email'><br><br>";
            echo "<label for='cr_pwd'>Password:</label><br>";
            echo "<input type='password' name='cr_pwd' id='cr_pwd'><br><br>";
            echo "<label for='address'>Address:</label><br>";
            echo "<input type='text' name='address' id='address'><br><br>";
            echo "<label for='phn'>Phone Number:</label><br>";
            echo "<input type='text' name='phn' id='phn'><br><br>";
            echo "<label for='bill'>BillingInfo:</label><br>";
            echo "<input type='text' name='bill' id='bill'><br><br>";
            echo "<input type='submit' value='Create Account'>";
            echo "</form>";
            break;
          default:
            echo " ";
        }
      }
      else {
        echo "<form method='POST' action=''>";
        echo "<label for='action'>What would you like to do?</label>";
        echo "<select name='action' id='action' required>";
        echo "<option value=''>----Choose an option----</option>";
        echo "<option value='signin'>Sign In</option>";
        echo "<option value='create_account'>Create An Account</option>";
        echo "</select>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
      }
    ?>
  </body>
</html>
