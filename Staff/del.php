<?php
include "../conn.php";
$codereg = g('code');
$item = g('item');

$qry = "DELETE FROM `item` WHERE `item` = '$item'";
$result = mysqli_query($conn, $qry);
header("location: item.php?code=$codereg&type=employee_rgo");
exit;
?>