<?php
    include "../conn.php";

    $code = g('id');
    $order = (int) g('ord');

    if ($order > 0) {
        $qry = "DELETE FROM `orders` WHERE `Order_ID` = $order";
        mysqli_query($conn, $qry);
    }
    header("location: history.php?code=$code&type=student_rgo");
    exit;
    ?>