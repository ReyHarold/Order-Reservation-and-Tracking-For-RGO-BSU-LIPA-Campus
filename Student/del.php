<?php
    include "../conn.php";

    $code=$_GET['id'];
    $order=$_GET['ord'];

    $qry = "DELETE FROM `orders` WHERE `Order_ID` = $order";
    $result = mysqli_query($conn, $qry);
    header("location: history.php?code=$code&type=student_rgo");
    exit;
    ?>