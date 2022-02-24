<?php
include 'dbConn.php';
$data = stripslashes(file_get_contents("php://input"));
$mydata = json_decode($data, true);
$user_name  = $mydata['user_name'];
$usdt_rate  = $mydata['usdt_rate'];
$usdt_total = $mydata['usdt_total'];
$inr_total  = $mydata['inr_total'];
$id         = $mydata['id'];
//For Insert data only
if (!empty($user_name) && !empty($usdt_rate) && !empty($usdt_total) && !empty($inr_total)) {
    $sql = "INSERT INTO orders(user_name,usdt_rate,usdt_total, inr_total) VALUES ('$user_name','$usdt_rate','$usdt_total','$inr_total')";
    if ($conn->query($sql) == TRUE) {
        echo "Student Data Saved Sucessfully!!";
    } else {
        echo "Unable to Save!!";
    }
} else {
    echo "Fill all Fields!!";
}
//For Insert& Update data only

// if (!empty($name) && !empty($email) && !empty($password)) {
//     $sql = "INSERT INTO student(id,name,email, password) VALUES ('$id','$name','$email','$password') ON DUPLICATE KEY UPDATE name='$name',email='$email',password='$password'";
//     if ($conn->query($sql) == TRUE) {
//         echo "Student Data Saved Sucessfully!!";
//     } else {
//         echo "Unable to Save!!";
//     }
// } else {
//     echo "Fill all Fields!!";
// }
