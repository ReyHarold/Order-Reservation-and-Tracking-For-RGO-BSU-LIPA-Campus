<?php
include "../conn.php";
$codereg = g('code');
$name = p('itemn');
$imgData = "";
if (isset($_FILES['imgg']) && $_FILES['imgg']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['imgg']['tmp_name'])) {
    $imgData = addslashes(file_get_contents($_FILES['imgg']['tmp_name']));
}
if (isset($_POST['size'])){
    $price = p('prices', array());
    foreach ($price as $key){
       $qry = "INSERT INTO `item`( `item`, `price`, `size`, `img`) VALUES ('$name','".$key['price']."','".$key['size']."','$imgData')";
       $result = mysqli_query($conn, $qry);
    }
}else{
$pricez = p('price');
$size= "NONE";
$qry = "INSERT INTO `item`( `item`, `price`, `size`, `img`) VALUES ('$name','$pricez','$size','$imgData')";
$result = mysqli_query($conn, $qry);
};
header("location: item.php?code=$codereg&type=employee_rgo");
exit;
?>