<?php
include "../conn.php";
$codereg = $_GET['code'];
$keyq = $_GET['item'];
$name = $_POST['itemn'];
if (isset($_FILES['imgg']) && $_FILES['imgg']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['imgg']['tmp_name'])){
    $imgData = "`img`='".addslashes(file_get_contents($_FILES['imgg']['tmp_name']))."',";
}else{
    $imgData = " ";
}
if (isset($_POST['size'])){
    $price = $_POST['prices'];
    foreach ($price as $key){
       $qry = "UPDATE `item` SET $imgData `item`='$name',`price`='".$key['price']."',`size`='".$key['size']."' WHERE item = '$keyq' && `size`='".$key['size']."'";
       $result = mysqli_query($conn, $qry);
    }
}else{
$pricez = $_POST['price'];
$size= "NONE";
$qry = "UPDATE `item` SET $imgData `item`='$name',`price`='$pricez',`size`='$size' WHERE item = '$keyq'";
$result = mysqli_query($conn, $qry);
};
header("location: item.php?code=$codereg&type=employee_rgo");
exit;
?>