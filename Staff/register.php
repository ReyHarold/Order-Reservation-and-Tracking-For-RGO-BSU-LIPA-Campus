<?php
include "../conn.php";
$codereg = g('code');
$name = p('admname');
$code = p('idcode');
if (isset($_FILES['mm']) && $_FILES['mm']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['mm']['tmp_name'])) {
    $imgData = addslashes(file_get_contents($_FILES['mm']['tmp_name']));
    $qry = "UPDATE `employee_rgo` SET `img`= '$imgData' WHERE code = '$code'";
    $result = mysqli_query($conn, $qry);
}

header("location: home.php?code=$codereg&type=employee_rgo");
exit;
?>