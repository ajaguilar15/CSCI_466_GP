<html>
    <head>
    <title>Your cart</title>
    </head>
    <body>
     <?php
        
        //login
        $username="z2045088";
        $password="2005Jun23";
        try{
            $dsn = "mysql:host=courses;dbname=$username";
            $pdo = new PDO($dsn,$username,$password);
        }
        catch(PDOexception $e){
            echo "Connection to database failed: " . $e->getMessage();
        }

        //get user name
        $sel = "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USERID='$_POST[userID]';";
        $result = $pdo->query($sel);
        $show = $result->fetchALL();
        $name = $show[0];
        $fname = $name[0];
        $lname = $name[1];
        //$fname = $name[FIRST_NAME];
        //$lname = $name[LAST_NAME];

        //show user's shopping cart
    $sel = "SELECT PNAME, PRICE, USERQTY FROM PRODUCT JOIN SHOPPING_CART WHERE PRODUCT.PRODUCTID=SHOPPING_CART.PRODUCTID AND USERID='$_POST[userID]';";
        $result = $pdo->query($sel);
        $show = $result->fetchALL(PDO::FETCH_ASSOC);
        
        //get the total for each product aas we display the cart
        $prodTot=0;
        $Total=0;
        echo "<h1>$fname $lname's Cart</h1>";

        //table displaying cart
        echo "<table border=3><tbody>";
        echo "<tr>";
        echo "<th>Product Name</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Product Total</th>";
        echo "</tr>";
        foreach($show as $r){
            echo "<tr>";
            foreach($r as $c){
                echo "<th>$c</th>";
            }
            $prodTot = $r['PRICE'] * $r['USERQTY'];
            $Total = $Total + $prodTot;
            echo "<th>$prodTot</th>";
            echo "</tr>";
            //probably need to find a way to remove or add more products from here
        }
        echo "</tbody></table>";

        //see total and purchase
        echo "<form method=POST action=>";
        echo "Your total is $$Total ";
        echo "<input type=submit name=Purchase value=Purchase>";
        echo "<input type=hidden name=email value=$_POST[email]>";
        echo "<input type=hidden name=pwd value=$_POST[pwd]>";
        echo "<input type=hidden name=userID value=$_POST[userID]>";
        echo "</form>";

        //add code to add billing info and finalize purchase and whatnot
     ?>
    </body>
</html>
