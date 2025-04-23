"Store/Orders.php": """<?php
session_start();
include 'DB.php';

$userid = $_SESSION['userid'] ?? 'U1'; // For demo purposes
$stmt = $conn->prepare("SELECT * FROM ORDERS WHERE USERID = :uid ORDER BY ORDERDATE DESC");
$stmt->execute([':uid' => $userid]);

echo "<h1>Your Orders</h1>";
echo "<table border='1'><tr><th>Order ID</th><th>Status</th><th>Total</th><th>Date</th></tr>";
while ($row = $stmt->fetch()) {
    echo "<tr><td>{$row['ORDERID']}</td><td>{$row['OSTATUS']}</td><td>\${$row['TOTAL']}</td><td>{$row['ORDERDATE']}</td></tr>";
}
echo "</table>";
?>"""
