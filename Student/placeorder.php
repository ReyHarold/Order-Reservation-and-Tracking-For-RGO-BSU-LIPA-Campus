<html>
<?php 
include "../conn.php";
            $item = $_POST['item'];
            $tagsList=$_POST['sizes'];
            $videoids = explode(",", $tagsList);
            $size = $videoids[0];
            $price = $videoids[1];
            $cod = $_POST['codes'];
            $currentDate = date('Y-m-d');
            $quan = $_POST['quan'];
            $or_price = ($price * $quan);
            $code = $_GET['code'];
            if ($size == "Custom"){
                $size2 = $_POST['width']."X".$_POST['length'];
            }else{
                $size2 = $size;
            }
            $qry = "INSERT INTO `orders`(`Item_ID`, `Date_Ordered`, `stud_code`, `size`, `quantity`, `price`, em_code) VALUES ((SELECT `Item_ID`FROM `item` WHERE `item`= '$item' and `size` ='$size'),'$currentDate',(SELECT `studid`FROM `student_rgo` WHERE `code` = '$code'),'$size2','$quan','$or_price', (SELECT `empid`FROM `employee_rgo` WHERE `code` = '123123'))";
            $result= mysqli_query($conn,$qry);

            header("location: home.php?code=$code&type=student_rgo");
            exit;
?>
</html>