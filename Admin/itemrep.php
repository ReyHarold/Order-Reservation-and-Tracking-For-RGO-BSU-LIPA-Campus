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
    </div>

</div>

            <tr>
              
              <th scope="col">Item ID</th>
              <th scope="col">Item</th>
              <th scope="col">Price</th>
              <th scope="col">Size</th>

            </tr>
          </thead>
          <tbody>
          <?php
                $code = g('code');
                $totalp = 0;
                $totalq = 0;
                $qry = "SELECT * FROM `item`";
                $result = mysqli_query($conn, $qry);
                while($row= mysqli_fetch_assoc($result)){
                echo "<tr scope='row'>";
                echo "<td>".$row['Item_ID']."</td>";
                echo "<td>".$row['item']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "<td>".$row['size']."</td>";
                echo "</tr>";
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
                </tr>"
                
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