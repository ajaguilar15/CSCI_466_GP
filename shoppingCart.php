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

        //head back to view products
        echo "<form method=POST action=https://students.cs.niu.edu/~z2045088/products.php>";
        echo "<input type=hidden name=email value=$_POST[email]>";
        echo "<input type=hidden name=pwd value=$_POST[pwd]>";
        echo "<input type=hidden name=userID value=$_POST[userID]>";
        echo "<input type=submit value='View Items'>";
        echo "</form>";

        //show user's shopping cart
    $sel = "SELECT SHOPPING_CART.PRODUCTID, PNAME, PRICE, USERQTY FROM PRODUCT JOIN SHOPPING_CART WHERE PRODUCT.PRODUCTID=SHOPPING_CART.PRODUCTID AND USERID='$_POST[userID]' AND ORDERCHECK='FALSE';";
        $result = $pdo->query($sel);
        $show = $result->fetchALL(PDO::FETCH_ASSOC);
        $prodList=$show;


        //get the total for each product aas we display the cart
        $prodTot=0;
        $Total=0;
        echo "<h1>$fname $lname's Cart</h1>";

        
        //update the quantity amount
        //basically add or remove quantity of items
        if($_POST['changeQTY'] != NULL){
            foreach($prodList as $r){
                if($r['PRODUCTID'] == $_POST['pchange']){
                    $pamount=$r['USERQTY'];
                }
            }

            //adding or removing
            if($_POST['change'] == 'Add'){
                $changeQTY = $pamount + $_POST['changeQTY'];
            }
            if($_POST['change'] == 'Remove'){
                $changeQTY = $pamount - $_POST['changeQTY'];
            }

            //if less than zero then remove item from list
            if($changeQTY < 1){
                $sel = "DELETE FROM SHOPPING_CART WHERE USERID='$_POST[userID]' AND PRODUCTID='$_POST[pchange]' AND ORDERCHECK='FALSE';";
            }
            else{
                $sel = "UPDATE SHOPPING_CART SET USERQTY='$changeQTY' WHERE USERID='$_POST[userID]' AND PRODUCTID='$_POST[pchange]' AND ORDERCHECK='FALSE';";
            }
            $result = $pdo->prepare($sel);
            $succ = $result->execute();

            //update prodList
            $sel = "SELECT SHOPPING_CART.PRODUCTID, PNAME, PRICE, USERQTY FROM PRODUCT JOIN SHOPPING_CART WHERE PRODUCT.PRODUCTID=SHOPPING_CART.PRODUCTID AND USERID='$_POST[userID]' AND ORDERCHECK='FALSE';";
            $result = $pdo->query($sel);
            $show = $result->fetchALL(PDO::FETCH_ASSOC);
            $prodList=$show;
        }

        //makes sure there's a max amount of a product otherwise
        //the user would be paying for nonexistant products
        $psel = "SELECT PRODUCT.PRODUCTID, STOCKQTY FROM PRODUCT JOIN SHOPPING_CART WHERE PRODUCT.PRODUCTID=SHOPPING_CART.PRODUCTID AND USERID='$_POST[userID]' AND ORDERCHECK='FALSE';";
        $result = $pdo->query($psel);
        $stock = $result->fetchALL(PDO::FETCH_ASSOC);


        //checks if user amount is greater than stock amount
        $incr=0;
        foreach($prodList as $r){
            $stockC = $stock[$incr];

            if($r['USERQTY'] > $stockC['STOCKQTY']){
                $upsel = "UPDATE SHOPPING_CART SET USERQTY='$stockC[STOCKQTY]' WHERE USERID='$_POST[userID]' AND PRODUCTID='$r[PRODUCTID]' AND ORDERCHECK='FALSE';";
                $result = $pdo->query($upsel);
                $result->fetchALL(PDO::FETCH_ASSOC);
            }
            $incr = $incr + 1;
        }

        //update product list after every change
        //in order to properly display current cart
        $sel = "SELECT SHOPPING_CART.PRODUCTID, PNAME, PRICE, USERQTY FROM PRODUCT JOIN SHOPPING_CART WHERE PRODUCT.PRODUCTID=SHOPPING_CART.PRODUCTID AND USERID='$_POST[userID]' AND ORDERCHECK='FALSE';";
        $result = $pdo->query($sel);
        $prodList = $result->fetchALL(PDO::FETCH_ASSOC);




        //table displaying cart
        echo "<table border=3><tbody>";
        echo "<tr>";
        echo "<th>Product ID</th>";
        echo "<th>Product Name</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Product Total</th>";
        echo "</tr>";

        foreach($prodList as $r){
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

        
        if(empty($_POST['total'])){ //////////////////////only show if not placing order yet
        //allow user to change quantity of a product
        echo "<br>";
        echo "Change the quantity of a product";
        echo "<br>";
        echo "<form method=POST action=>";
        echo "<select name=pchange>";
        foreach($prodList as $r){
            echo "<option value=$r[PRODUCTID]>$r[PRODUCTID]</option>";
        }
        echo "/<select>";
        echo "<select name=change>";
        echo "<option value=Add>Add</option>";
        echo "<option value=Remove>Remove</option>";
        echo "</select>";
        echo "<input type=number name=changeQTY min=1>";        
        echo "<input type=hidden name=email value=$_POST[email]>";
        echo "<input type=hidden name=pwd value=$_POST[pwd]>";
        echo "<input type=hidden name=userID value=$_POST[userID]>";
        echo "<input type=submit value='Change QTY'>";
        echo "</form>";

        $fTot = number_format($Total,2);
        //see total and purchase
        //use CURDATE() to get the current date
        //may need a date from shopping
        echo "<form method=POST action=>";
        echo "Your total is $$fTot";
        echo "<input type=submit name=Purchase value=Purchase>";
        echo "<input type=hidden name=total value=$Total>";
        echo "<input type=hidden name=email value=$_POST[email]>";
        echo "<input type=hidden name=pwd value=$_POST[pwd]>";
        echo "<input type=hidden name=userID value=$_POST[userID]>";
        echo "</form>";
        }//////////////////////////////////////////////only show if not placing order

        if($_POST['total'] != NULL){
            $fTot = number_format($_POST['total'],2);
            $ran = bin2hex(random_bytes(1));
            $valids = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $ran = substr(str_shuffle($valids),0,2);
            $rando = "$ran";
            echo "$rando";
            //random id, make sure to check order id does not exist with user id
            echo "<br>";
            echo "<form method=POST action=https://students.cs.niu.edu/~z2045088/orders.php>";
            echo "Your total is $$fTot <br>";
            echo "Input billing info: <br><br>";
            echo "Address: <br>";
            echo "<input type=text name=address> <br>";
            echo "Card number:<br>";
            echo "<input type=number name=cardNum>";
            echo "<input type=submit name=Order value='Place Order'>";
            echo "<input type=hidden name=total value=$_POST[total]>";
            echo "<input type=hidden name=email value=$_POST[email]>";
            echo "<input type=hidden name=pwd value=$_POST[pwd]>";
            echo "<input type=hidden name=userID value=$_POST[userID]>";
            echo "<input type=hidden name=ordered value=TRUE>";
            echo "<input type=hidden name=ORID value=$rando";
            echo "</form>";

        }

        //add code to add billing info and finalize purchase and empty cart etc, may need date, whatnot
     ?>
    </body>
</html>
