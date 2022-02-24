<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "armentum";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name) or die("Connection failed!");
if ($conn->connect_errno) {
    die("Connection Failed");
}
