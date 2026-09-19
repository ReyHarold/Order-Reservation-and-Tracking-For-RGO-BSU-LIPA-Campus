<?php
include "../conn.php";
            $item = p('item');
            $tagsList = p('sizes');
            $videoids = explode(",", $tagsList);
            $size = isset($videoids[0]) ? trim($videoids[0]) : '';
            $price = isset($videoids[1]) ? trim($videoids[1]) : '0';
            $cod = p('codes');
            $currentDate = date('Y-m-d');
            $quan = p('quan');
            $or_price = ($price * $quan);
            $code = g('code');
            if ($size == "Custom"){
                $size2 = p('width')."X".p('length');
            }else{
                $size2 = $size;
            }
            $qry = "INSERT INTO `orders`(`Item_ID`, `Date_Ordered`, `stud_code`, `size`, `quantity`, `price`, em_code) VALUES ((SELECT `Item_ID`FROM `item` WHERE `item`= '$item' and `size` ='$size'),'$currentDate',(SELECT `studid`FROM `student_rgo` WHERE `code` = '$code'),'$size2','$quan','$or_price', (SELECT `empid`FROM `employee_rgo` WHERE `code` = '123123'))";
            $result= mysqli_query($conn,$qry);

            header("location: home.php?code=$code&type=student_rgo");
            exit;
?>