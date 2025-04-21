<html>
  <head>
  <title>Products</title>
  </head>
  <body>
  <h1>Products</h1>
  <?php
    $username="z2045088";
    $password="2005Jun23";

    try{
        $dsn = "mysql:host=courses;dbname=z2045088";
        $pdo = new PDO($dsn,$username, $password);
    }
    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }

    $sel = "SELECT * FROM PRODUCT ORDER BY PRODUCTID;";
    $result = $pdo->query($sel);
    $show = $result->fetchALL(PDO::FETCH_ASSOC);

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

    echo"<form method=POST action=>";
    echo "<select name=ProdName>";
         echo "<option value=SelectProd>-Select Product-</option>";
         foreach($show as $r){
             echo "<option value=$r[ProductID]>$r[PRODUCTID]</option>";
         }
    echo "</select>";
    echo "<input type=number min=1 name=USRQTY>";
    echo "<input type=submit value=Add>";
    echo"</form>";

    //need a way to identify user and then add products to users shopping cart


  ?>
  </body>
</html>
