<?php
session_start();
$user_name = $_SESSION['alogin'];
include 'dbConn.php';
$sql = "SELECT * from  orders where user_name = '$user_name' and  DATE(order_date) = CURDATE();";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
