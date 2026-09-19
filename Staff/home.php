<?php
include "../template.php";
?>
<script>
        document. getElementById("addadmin"). classList.add('change-pass');
        code = document. getElementById("code").innerHTML;
        document. getElementById("templatebut"). href = "item.php?code="+code+"&type=employee_rgo";
        document. getElementById("templatebut2"). innerHTML = "Item List";
</script>
<style>
    .pop,.quak{
    left:35vw;
    position: absolute;
    top:25%;
    height:70vh;
    width:35vw;
    background-color:white;
    display:flex;
    flex-direction:column;
    border:2px solid black;
    border-radius:20px;
}
.close{
    transform:scale(0);
}
.pop .clos .icon{
    transform:scale(2);
}
.pop .clos, .quak .clos{
    position:absolute;
    height:20px;
    top:5px;
    right:10px;
    background-color:white;
    border:none;
}
.pop div{
    display:flex;
    justify-content:center;
    margin-top:30px;
    margin-left:10px;
}
.pop div label{
    margin-right:30px;
    margin-top:10px;
    text-decoration:none;
}
.order {
    margin:30px 0 !important;
    width:100%;
}
.order input{
    margin:0 auto;
    width:100px;
    height:24px;
    border-radius:5px;
}
.inim{
    margin:auto 0;
}
.quak{
    top:20%;
    position:fixed;
    height:30vh;
    width:35vw;
    padding:30px;
    text-align:center;
}
.quak input,.quak div{
    margin:0 auto;
    width:50%;
}
.quak div label{
    margin-right:10px;
}
</style>
<div id="pop">
    <form id = "popform" class="pop close" enctype="multipart/form-data" action="register.php?code=<?php echo "$code"?>" method="POST">
        <button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
        <div><label for = "Code">Code: </label><input name='idcode' type="text" width="48" height="48"></div>
        <div><label for = "Name">Name: </label><input name='admname' type="text" name="Name" alt="Submit"></div>
        <div><label for = "Email">Email: </label><input name='admemail'type="email" name="Email" alt="Submit"></div>
        <div><label for = "Password">Password: </label><input name='admpass' type="text" name="Password"></div>
        <div><label for = "image">Add Image: </label><input type="file" name="mm" class= "inim" id="imageInput"></div>
        <div class="order"><input type="submit" name="Register" value="Register"></div>
    </form>
    <script>
        function close12(){
        document.getElementById("popform").classList.add("close");
        document.getElementById("usure").classList.add("close");
    };
    function popup(){
        document.getElementById("popform").classList.remove("close");
    };
    function areyousure(orderID,status){
        document.getElementById("usure").action ="edit.php?code=<?php echo"$code"?>&id="+orderID+"&stat="+status+""
        document.getElementById("usure").setAttribute("onSubmit", "return submitForm("+orderID+");");
        document.getElementById("usure").classList.remove("close");
    }
    function submitForm(orderID){
        var check = document.getElementById("asdzxc").value;
            if(orderID==check){
                return true;
           }
           else{
               alert("Wrong Order ID!")
               return false;
           }
    }
    </script>
<div class="container">
    <form class = "quak close" action="" id = "usure" method="post" class="sure">
    <button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
        <h1>Are you sure ?</h1>
        <div><label>Order ID:</label><input type="text" id="asdzxc"></div>
        <input type="submit" value="Yes">
    </form>
  <ul class="responsive-table">
  <table class="table custom-table">
  <thead>
            <tr>
              
              <th scope="col">Order ID</th>
              <th scope="col">Student ID</th>
              <th scope="col">Order Description</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Date Recieved</th>
              <th scope="col">Price</th>
              <th scope="col">Update Status</th>
            </tr>
          </thead>
          <tbody>
              <?php
                $code = g('code');
                $qry = "SELECT a.*, b.code, c.item, c.size, c.price FROM `orders` as a inner join item as c ON a.`Item_ID` = c.Item_ID inner join student_rgo as b ON a.stud_code = b.studid WHERE NOT `statuss` = 'Recieved' ORDER BY Order_ID;";
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
                echo "<td>".$row['price']."</td>";
                echo "<td><button onclick='areyousure(".$row['Order_ID'].",`".$row['statuss']."`)' class = 'button ".$row['statuss']."' type='button'>".$row['statuss']."</button></td>";
                echo "</tr>";
                }
                ?>
</div>
<?php include "../footer.php"; ?>