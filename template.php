<?php include "conn.php";
$code = g('code');
$type = g('type');
// only allow the two known profile tables as the FROM target
if ($type !== 'student_rgo' && $type !== 'employee_rgo') {
    $type = 'student_rgo';
}
if ($type == 'student_rgo'){
    $qry="SELECT a.*, b.lastname, b.firstname, b.course FROM $type AS a 
     INNER JOIN tbstudinfo AS b ON a.`studid`= b.`studid` WHERE code='$code' GROUP BY `studid`"; 
}else{
    $qry="SELECT a.*, b.lastname, b.firstname FROM $type AS a 
    INNER JOIN tbempinfo AS b ON a.`empid`= b.`empid` WHERE code='$code' GROUP BY `empid`";
}

$result=mysqli_query($conn,$qry);
$row = $result ? mysqli_fetch_array($result) : array();
if (!$row) { $row = array(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Generation Office</title>
    <link rel="stylesheet" href="../template.css">
    <link rel="stylesheet" href="../Includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Includes/css/style.css">

</head>
<body>
    <div class="top-nav"><img src="../img/logo.jpg" alt="SchoolLogo"><h2>Resource Generation Office BatState-U</h2></div>
    <div class="mid-nav">
        <div id ="addadmin"></div>
        <div class="sign-out"><ion-icon class = "icon"name="power-outline"></ion-icon><a href="../index.php "><input type="button" value="Sign-Out"></a></div></div>
    <div class="info">
    <?php 
    echo '<div class="infoimg"><img src="data:image/png;base64,'.base64_encode($row['img'] ?? '').'"/></div>';
    echo "<ul class='text'><li id='name'>".($row['lastname'] ?? '').", ".($row['firstname'] ?? '')."</li>";
    echo "<li id='code'>".($row['code'] ?? '')."</li>";
    if ($type == "student_rgo"){
    echo "<li id='course'>".($row['course'] ?? '')."</li></ul>";
    }else{
        echo "<li id='course'>".($row['email'] ?? '')."</li></ul>";
    }
    ?>
    <div id ="sidebutt" class="sidebutt">
    <a href="" id = "templatebut" class="templatebut"><button type="button" id = "templatebut2"class="templatebut"></button></a>
    </div>
</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>