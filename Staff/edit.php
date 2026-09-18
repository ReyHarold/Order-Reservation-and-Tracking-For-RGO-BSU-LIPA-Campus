<?php
include "../conn.php";
$orderID = $_GET['id'];
$code = $_GET['code'];
$stat = $_GET['stat'];
$currentDate = date('Y-m-d');
if ($stat == "Pending"){
$qry = "UPDATE `orders` SET `statuss`='Ready for Pickup' WHERE Order_ID = '$orderID'";
}else{
$qry = "UPDATE `orders` SET `statuss`='Recieved',`Date_Recieved`='$currentDate',`em_code`=(SELECT `empid` FROM `employee_rgo` WHERE `code` = '$code') WHERE Order_ID = '$orderID'";
}
$result = mysqli_query($conn, $qry);
header("location: home.php?code=$code&type=employee_rgo");
exit;
?>