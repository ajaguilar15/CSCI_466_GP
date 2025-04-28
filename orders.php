<html>
    <head>
    <title>Your order</title>
    </head>
    <body>
     <?php
        $username="z2045088";
        $password="2005Jun23";
        try{
            $dsn = "mysql:host=courses;dbname=$username";
            $pdo = new PDO($dsn,$username,$password);
        }
        catch(PDOexception $e){
            echo "Connection to database failed: " . $e->getMessage();
        }

        if($_POST['ordered']== 'TRUE'){
            $sel = "SELECT CURDATE();";
            $result = $pdo->query($sel);
            $show = $result->fetchALL();
            $td = $show[0];
            $thedate=$td[0];
            echo "yup";
            $valids = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $ran = substr(str_shuffle($valids),0,2);
            echo "$thedate";
            $oi = $_POST['ORID'];
            echo "<br> $_POST[ORID]";
            echo "<br> $ran";
            echo "<br> $_POST[userID]";
            echo "<br> $_POST[total]";
            $proc = "PROCESSING";
            echo "<br> $proc";
            $shopsel = "UPDATE SHOPPING_CART SET CARTDATE='$thedate' WHERE USERID='$_POST[userID]' AND CARTDATE IS NULL;";

            $ordersel = 'INSERT INTO ORDERS VALUES(:date, :order, :user, :tot, :proc);';
            $result = $pdo->prepare($ordersel);
 //USER ID MUST BE PRIMARY
            //REMOVE ITEMS FROM STOCK
            $succ = $result->execute(array(':date' => $thedate, ':order' => $ran, ':user' => $_POST['userID'], ':tot' => $_POST['total'], ':proc' => "$proc"));
            $result = $pdo->prepare($shopsel);
            $succ = $result->execute();

            $sel = "SELECT * FROM ORDERS;";
            $result = $pdo->query($sel);
            $show = $result->fetchALL();
            $s = $show[0];
            echo "$s[ORDERDATE]";
            //$succ = $result->execute(array(':o' => $_POST['ORID'], ':u' => $_POST['userID'], ':t' => $_POST['total']));
        }
     

     ?>
    </body>
</html>
