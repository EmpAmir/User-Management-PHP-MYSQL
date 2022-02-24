<?php
include 'dbConn.php';
$data = stripslashes(file_get_contents("php://input"));
$mydata = json_decode($data, true);
$user_name  = $mydata['user_name'];
$inr_total  = $mydata['inr_total1'];
$utr        = $mydata['utr'];
$id         = $mydata['id'];
//For Insert data only
if (!empty($user_name) && !empty($inr_total) && !empty($utr)) {
    $sql = "INSERT INTO sell(user_name, inr_total,utr) VALUES ('$user_name','$inr_total','$utr')";
    if ($conn->query($sql) == TRUE) {
        echo "Sell Data Saved Sucessfully!!";
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
