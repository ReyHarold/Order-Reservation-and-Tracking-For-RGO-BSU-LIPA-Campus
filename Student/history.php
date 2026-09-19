<?php
include "../template.php";
?>
<script> 
       code = document. getElementById("code").innerHTML;
        document. getElementById("templatebut"). href = "home.php?code="+code+"&type=student_rgo";
        document. getElementById("templatebut2"). innerHTML = "Back to Ordering";
</script>
<style>
.content{
    width:100%;
    display:flex;
    flex-direction:column;
    justify-content:space-around;
}
.row{
    width:100%;
    display:flex;
    justify-content:space-around;
}
.row input{

}
.row button{
    height:200px;
    width:200px;
}
.row img{
    width:100%;
}
.pop{
    left:25vw;
    top:15%;
    position: absolute;
    height:70vh;
    width:50vw;
    background-color:white;
    display:flex;
    flex-direction:column;
    border:2px solid black;
    border-radius:20px;
}
.pop img{
    height:200px;
    width:200px;
}
.pop .up{
    display:flex;
}
.pop .up img{
    margin:10px;
    border:1px solid black;
}
.pop .up div, .pop .down{
    margin: 10px;
}
.pop label{
    margin-left:30px;
    margin-top:10px;
    text-decoration:none;
}
.pop .middle{
    display:flex;
    justify-content:space-around;
    flex-direction:column;
}
.pop .middle div{
    display:flex;
    justify-content:space-between;
    max-width:250px;
    margin-left:10px;
}
.pop .middle div input{
    margin-left:50px;
}
.pop .clos{
    position:absolute;
    height:20px;
    top:5px;
    right:10px;
    background-color:white;
    border:none;
}
.close{
    display:none;
}
.pop .clos .icon{
    transform:scale(2);
}
.pop ul li, .pop h1{
    font-size:24px;
    margin:10px auto;
    width:80%;
}
.pop h1{
    font-size:32px !important;
}
.order {
    margin:0 auto;
}
.order input{
    width:100px;
    height:24px;
    border-radius:5px;
}

</style>
<div id = "pop"class="pop">
<button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
<h1>How to claim my orders:</h1>
<ul>
    <li>Check your order status daily</li>
    <li>If the status is <span style="color:red;">Pending</span>, your order is not ready yet</li>
    <li>If the status is <span style="color:green;">Ready for Pickup</span>, please claim your order in resource generation office and bring the ff:</li>
    <ul>
        <li style="width:60%;">Id for verification</li>
        <li style="width:60%;">Payment for the order</li>
    </ul>
    <li>Please verify the orders before leaving the office</li>
    <li>Thank you!</li>
</ul>
</div>
<div class="container">
  <ul class="responsive-table">
  <table class="table custom-table">
  <thead>
            <tr>
              
              <th scope="col">Order ID</th>
              <th scope="col">Order Description</th>
              <th scope="col">Status</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Date Recieved</th>
              <th scope="col">Quantity</th> 
              <th scope="col">Price</th>
              <th scope="col">Cancel Order</th>
            </tr>
          </thead>
          <tbody>
    <?php
    $code = g('code');
    $qry = "SELECT a.Order_ID,a.quantity,b.price, b.item, a.statuss, a.Date_Ordered, a.Date_Recieved, a.`em_code`, b.size
    FROM orders AS a
    INNER JOIN item AS b ON a.Item_ID = b.Item_ID
    WHERE a.`stud_code` = (SELECT `studid` from student_rgo where `code` ='$code') ORDER BY Order_ID DESC;";
    $result = mysqli_query($conn, $qry);
    while($row= mysqli_fetch_assoc($result)){
    echo "<tr scope='row'>";
    echo "<td>".$row['Order_ID']."</td>";
    if ($row['size'] == "NONE"){
        echo "<td>".$row['item']."</td>";
    }else{
        echo "<td>".$row['item']." (".$row['size'].")</td>";
    }
    echo "<td class='".$row['statuss']."text'>".$row['statuss']."</td>";
    echo "<td>".$row['Date_Ordered']."</td>";
    echo "<td>".$row['Date_Recieved']."</td>";
    echo "<td>".$row['quantity']."</td>";
    echo "<td>".$row['price']*$row['quantity'].".00</td>";
    echo "<td>";
    if ($row['statuss'] == "Pending"){
    echo "<a href ='del.php?ord=".$row['Order_ID']."&id=$code'><button class='button' type='button'>Cancel</button></a>";
    };
    echo "</td>";
    echo "</tr>";
    }
    ?>
  </ul>
</div>
<script>
    function close12(){
        document.getElementById("pop").classList.add("close");
    };
</script>
<?php include "../footer.php"; ?>