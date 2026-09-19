<?php
include "../template.php";
?>
<style>
.pop .clos{
    position:absolute;
    height:20px;
    top:5px;
    right:10px;
    background-color:white;
    border:none;
}

.pop{
    top:10%;
    left:30vw;
    position: fixed ;
    height:85vh;
    width:45vw;
    background-color:white;
    border:2px solid black;
    border-radius:20px;
    z-index: 999;
    transition:.3s;
}
.close{
    transform:scale(0);
}
.pop .clos .icon{
    transform:scale(2);
}
.pop div, .pop ul li{
    margin:20px 10px;
    list-style:none;
}
.pop input{
    padding:10px;
}
.pop label{
    width:100px;
    margin:0 5px;
}
.pop .checkboxes{
    display:flex;
    flex-direction:column;
}
</style>
<script>
         code = document. getElementById("code").innerHTML;
         document.getElementById("templatebut2").style="display:none;";
        function makeR(){
          document.getElementById("popform").classList.remove("close");
        }
        function close12(){
        document.getElementById("popform").classList.add("close");
    };
</script>
<div class="container">
    <form class= "pop close" id="popform" target="_blank" action="report.php?code=<?php echo "$code"?>&type=employee_rgo" method="post">
    <button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
    <div><label for="Item">Item Name:</label><input type="text" name="itemn" placeholder="leave blank to select all"></div>
    <div><label for="StudentID">Student ID:</label><input type="text" name="studentn" id="" placeholder="leave blank to select all"></div>
    <div><label for="date">From:</label><input type="date" name="datefrom" id="" required></div>
    <div><label for="date">To:</label><input type="date" name="dateto" id="" required></div>
    <div><label for="status">Status:</label>
    <div class="checkboxes">
    <div><label>Pending: </label>
    <input type="checkbox" name="check[]" value='"Pending"'>
  </div>
    <div><label>Ready for Pickup: </label>
    <input type="checkbox" name="check[]" value='"Ready for Pickup"'>
  </div>
    <div><label>Recieved: </label>
    <input type="checkbox" name="check[]" value='"Recieved"'>
  </div>
  </div>
  </div>
    <div style="text-align:center;"><input type="submit" value="Report"></div>
    </form>
</div>
  <ul class="responsive-table">
  <table class="table custom-table">
  <thead>
    <tr>
      <th><button style="padding:10px;" type="button" onclick="makeR()">Order Report</button></th>
      <th><a href="itemrep.php?code=<?php echo "$code"?>&type=admin" target="_blank"><button style="padding:10px;" type="button">Item Report</button></a></th>
    </tr>
            <tr>
              
              <th scope="col">Order ID</th>
              <th scope="col">Student ID</th>
              <th scope="col">Order Description</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Date Recieved</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Admin</th>
            </tr>
          </thead>
          <tbody>
              <?php
                $code = g('code');
                $qry = "SELECT a.*, b.code, c.item, c.size, c.price, d.code as admincode FROM `orders` as a 
                inner join employee_rgo as d ON a.em_code = d.empid 
                inner join item as c ON a.`Item_ID` = c.Item_ID 
                inner join student_rgo as b ON a.stud_code = b.studid WHERE `statuss` = 'Recieved' ORDER BY Order_ID";
                $result = mysqli_query($conn, $qry);
                while($row= mysqli_fetch_assoc($result)){
                echo "<tr scope='row'>";
                echo "<td>".$row['Order_ID']."</td>";
                echo "<td>".$row['code']."</td>";
                if ($row['size'] == "NONE"){
                    echo "<td>".$row['item']."</td>";
                }else{
                    echo "<td>".$row['item']." (".$row['size'].")</td>";
                }
                echo "<td>".$row['Date_Ordered']."</td>";
                echo "<td>".$row['Date_Recieved']."</td>";  
                echo "<td>".$row['quantity']."</td>";  
                echo "<td>".$row['price']*$row['quantity']."</td>";
                echo "<td>".$row['admincode']."</td>";
                echo "</tr>";
                }
                ?>
</div>
<?php include "../footer.php"; ?>