<html>
  <head>
  <title>Products</title>
  </head>
  <body>
  <h1>Products</h1>
  <?php

    //go back to user login if no account exists
    if(empty($_POST['email']) || empty($_POST['pwd'])){
         header('Location: https://students.cs.niu.edu/~z2045088/accounts.php');
       exit;
    }

    //login
    $username="z2045088";
    $password="2005Jun23";

        try{
            $dsn = "mysql:host=courses;dbname=z2045088";
            $pdo = new PDO($dsn,$username, $password);
        }
        catch(PDOexception $e){
            echo "Connection to database failed: " . $e->getMessage();
        }

        //go back to user login if no account exists
        $sel = "SELECT USERID FROM USERS WHERE EMAIL='$_POST[email]' AND PASSWORD='$_POST[pwd]';";
        $result = $pdo->query($sel);
        $show = $result->fetchALL();
        $usID = $show[0];
        if(empty($usID[0])){
        header('Location: https://students.cs.niu.edu/~z2045088/accounts.php');
            exit;
        }
       
    //get list of products
    $sel = "SELECT * FROM PRODUCT ORDER BY PRODUCTID;";
    $result = $pdo->query($sel);
    $show = $result->fetchALL(PDO::FETCH_ASSOC);

    //show all products
    echo "<table border=3> <tbody>";
    echo "<tr>";
    echo "<th>Product ID</th>";
    echo "<th>Product Name</th>";
    echo "<th>Description</th>";
    echo "<th>Price</th>";
    echo "<th>Stock</th>";
    echo "</tr>";
    foreach($show as $r){
        echo "<tr>";
        foreach($r as $c){
            echo "<th>$c</th>";
        }
        echo "</tr>";
    }
    echo "</tbody> </table>";

    //add product to user's shopping cart
    echo"<form method=POST action=>";
    echo "<select name=ProdName>";
         echo "<option value=SelectProd>-Select Product-</option>";
         foreach($show as $r){
             echo "<option value=$r[PRODUCTID]>$r[PRODUCTID]</option>";
         }
    echo "</select>";
    echo "<input type=number min=1 name=USRQTY id=USRQTY>";
    echo "<input type=submit value=Add>";
    echo "<input type=hidden name=email id=email value=$_POST[email]>";
    echo "<input type=hidden name=pwd id=pwd value=$_POST[pwd]>";
    echo"</form>";

    //view user's shopping cart
    echo "<form method=POST action=https://students.cs.niu.edu/~z2045088/shoppingCart.php>";
    echo "<input type=hidden name=userID id=userID value=$usID[0]>";
    echo "<input type=hidden name=email id=email value=$_POST[email]>";
    echo "<input type=hidden name=pwd id=pwd value=$_POST[pwd]>";
    echo "<input type=submit value='View Cart'>";
    echo "</form>";

    //get the product that user wants to add
    $sel = "SELECT USERQTY FROM SHOPPING_CART WHERE USERID='$usID[0]' AND PRODUCTID='$_POST[ProdName]';";
    $result = $pdo->query($sel);
    $show = $result->fetchALL();
    $prQTY = $show[0];

    //add product if not on cart
    if(empty($prQTY[0])){
        $sel = 'INSERT INTO SHOPPING_CART VALUES(:ui, :pi, :qty, NULL);';
        $result = $pdo->prepare($sel);
        $succ = $result->execute(array(':ui' => $usID[0], ':pi'=> $_POST['ProdName'], ':qty' => $_POST['USRQTY']));

    //add user qty to cart if item is already stored in user's cart
    }else{
        $sum = $prQTY[0] + $_POST['USRQTY'];
        $sel = "UPDATE SHOPPING_CART SET USERQTY='$sum' WHERE USERID='$usID[0]' AND PRODUCTID='$_POST[ProdName]';";
        $result = $pdo->prepare($sel);
        $succ = $result->execute();
    }
  ?>
  </body>
</html>
