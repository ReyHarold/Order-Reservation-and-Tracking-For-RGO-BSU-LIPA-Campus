<html>
    <head>
    <link rel="stylesheet" href="../Includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Includes/css/style.css">
    <title>REPORT</title>
    <style>
        @media print {
            .invoice-container{
                max-width:unset;
                box-shadow:none;
                border:0px;
                background-color:white;
                height:100%;
                width:100%;
                position:fixed;
                top:0;
                left:0;
                margin:0;
                padding:15px;
                font-size:14px;
                line-height:18px;
            }
        }
    </style>
<?php
include "../conn.php";
$codereg = $_GET['code'];
$itemhol = 'b.item =';
$itemn = $_POST['itemn'];
if ($itemn ==""){
    $itemhol = "";
}else{
    $itemhol = $itemhol . "'$itemn' AND" ;
};
$studenthol = 'AND c.code =';
$studentn = $_POST['studentn'];
if ($studentn == ""){
    $studenthol = "";
}else{
    $studenthol = $studenthol . "'$studentn'";
};
$datefrom = $_POST['datefrom'];
$dateto = $_POST['dateto'];
$check = isset($_POST['check']) ? $_POST['check'] : array();
$hold = count($check) ? '('.implode(',',$check).')' : "('')";
?>
</head>
<body style="margin: 0 auto;
    max-width: 1000px; box-shadow: 0px 0px 20px gray;">
    <div class="button-container">
        <button style = " margin:10px;padding:10px; background-color:green; color:white; font-weight:bold;"id="print">Print</button>
    </div>
    <ul class="responsive-table">
            <div class="invoice-container">
  <table class="table custom-table">
  <thead>
    <div style="display:flex; padding-bottom:50px;">
    <img style = "max-width: 100px;
    border-radius: 100%;
    border:1px solid black; margin-right:20px;" src="../img/logo.jpg" alt="SchoolLogo">
    <div><h1 style = "margin:auto 0">RESOURCE GENERATION OFFICE</h1>
    <p style= "margin:0;"id="datenow"></p>
            <p style= "margin:0;">PERIOD: <?php echo "$datefrom - $dateto"?></p></div>

</div>

            <tr>
              
              <th scope="col">Order ID</th>
              <th scope="col">Item</th>
              <th scope="col">Student ID</th>
              <th scope="col">Status</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Date Recieved</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
            </tr>
          </thead>
          <tbody>
          <?php
                $code = $_GET['code'];
                $totalp = 0;
                $totalq = 0;
                $qry = "SELECT a.*, b.price, b.item, d.code As `admincode`, b.size, c.code
                FROM orders AS a
                INNER JOIN item AS b ON a.Item_ID = b.Item_ID
                INNER JOIN employee_rgo AS d ON a.em_code = d.empid
          INNER JOIN student_rgo AS c ON a.stud_code = c.studid WHERE $itemhol a.statuss IN $hold AND `Date_Ordered` >= '$datefrom' AND `Date_Ordered` <= '$dateto' AND `Date_Recieved` <= '$dateto' $studenthol";
                $result = mysqli_query($conn, $qry);
                while($row= mysqli_fetch_assoc($result)){
                    $price = $row['quantity']* $row['price'];
                echo "<tr scope='row'>";
                echo "<td>".$row['Order_ID']."</td>";
                echo "<td>".$row['item']."</td>";
                echo "<td>".$row['code']."</td>";
                echo "<td>".$row['statuss']."</td>";
                echo "<td>".$row['Date_Ordered']."</td>";
                echo "<td>".$row['Date_Recieved']."</td>";  
                echo "<td>".$row['quantity']."</td>";
                echo "<td>P".$price."</td>";
                echo "</tr>";

                $totalp = $totalp + $price;
                $totalq = $totalq + $row['quantity'];
                }
                echo "
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                <td>TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>$totalq</td>
                <td>P$totalp.00</td>
                </tr>
                ";
                echo"
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>";
                ?>
</div>
            </div>
            </a>
<script src="../Includes/js/jquery-3.3.1.min.js"></script>
    <script src="../Includes/js/popper.min.js"></script>
    <script src="../Includes/js/bootstrap.min.js"></script>
    <script src="../Includes/js/main.js"></script>
    <script src="html2canvas.js"></script>
<script>
    document.getElementById('datenow').innerHTML = getCurrentDateAndTime()

    function getCurrentDateAndTime() {
  const dateTime = new Date();
  return dateTime.toLocaleString();
}
    var printBtn = document.querySelector('#print');
    var saveBtn = document.querySelector('#save');

    printBtn.addEventListener("click", function() {
        window.print();
    });

</script>
</body>
</html>