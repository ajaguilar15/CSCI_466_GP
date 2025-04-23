
    "Store/Cart.php": """<?php
session_start();
include 'DB.php';

$userid = $_SESSION['userid'] ?? 'U1'; // For demo purposes

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $productid = $_GET['productid'];
    $stmt = $conn->prepare("INSERT INTO SHOPPING_CART (USERID, PRODUCTID, USERQTY)
                            VALUES (:uid, :pid, 1)
                            ON DUPLICATE KEY UPDATE USERQTY = USERQTY + 1");
    $stmt->execute([':uid' => $userid, ':pid' => $productid]);
    header("Location: Cart.php");
    exit;
}

echo "<h1>Your Cart</h1>";
$stmt = $conn->prepare("SELECT P.PNAME, P.PRICE, C.USERQTY 
                        FROM SHOPPING_CART C
                        JOIN PRODUCT P ON C.PRODUCTID = P.PRODUCTID
                        WHERE C.USERID = :uid");
$stmt->execute([':uid' => $userid]);
$total = 0;
echo "<table border='1'><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>";
while ($row = $stmt->fetch()) {
    $subtotal = $row['USERQTY'] * $row['PRICE'];
    echo "<tr><td>{$row['PNAME']}</td><td>{$row['USERQTY']}</td><td>\${$row['PRICE']}</td><td>\${$subtotal}</td></tr>";
    $total += $subtotal;
}
echo "<tr><td colspan='3'>Total</td><td>\${$total}</td></tr></table>";
?>"""
