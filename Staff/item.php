<?php
include "../template.php";
?>
<script>
         code = document. getElementById("code").innerHTML;
        document. getElementById("templatebut"). href = "home.php?code="+code+"&type=employee_rgo";
        document. getElementById("templatebut2"). innerHTML = "Current Purchases";
</script>
<style>

    .text{
        padding:5px;
        margin-left:5px;
    }
    .search{
        width:50px;
        border:1px solid black;
        margin-left:2px;
        padding:5px;
    }
    .search .icon{
        height:100%:
    }
    .pop .clos{
    position:absolute;
    height:20px;
    top:5px;
    right:10px;
    background-color:white;
    border:none;
}

.pop{
    top:25%;
    left:35vw;
    position: fixed ;
    height:50vh;
    width:35vw;
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
.pop div{
    margin:20px 10px;
}
.pop input{
    padding:10px;
}
.pop label{
    width:100px;
    margin:0 5px;
}
.long{
    height:65vh;
    transform:translateY(-15vh);
}
</style>
<div class="container">
    <form id = "popform" class="pop close" enctype="multipart/form-data" action="additem.php?code=<?php echo "$code"?>" method="POST">
    <button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
        <div><label for = "Code">Item Name: </label><input id="iteName" name='itemn' type="text" width="48" height="48"></div>
        <div><label for = "Size">Sizeable: </label><input onclick="hide()" id="sizesa" name='size' type="checkbox" name="Name" alt="Submit"></div>
        <div id="size" hidden><label for = "Size">Small Price: </label><input id="smallPrice" name='prices[0][price]'type="text" alt="Submit"><input hidden type="text" name="prices[0][size]" alt="Submit" value="Small">
        <br><label for = "Size">Medium Price: </label><input id="medPrice" name='prices[1][price]'type="text" alt="Submit"><input hidden type="text" name="prices[1][size]" alt="Submit" value="Medium">
        <br><label for = "Size">Large Price: </label><input id="largePrice"name='prices[2][price]'type="text" alt="Submit"><input hidden type="text" name="prices[2][size]" alt="Submit" value="Large">
        <br><label for = "Size">Custom Price: </label><input id="cusPrice"name='prices[3][price]'type="text" alt="Submit"><input hidden type="text" name="prices[3][size]" alt="Submit" value="Custom"></div>
        <div id="sizeprice"><label for = "Price">Price: </label><input id = 'nonePrice'name='price' type="text"></div>
        <div><label for = "image">Add Image: </label><input type="file" name="imgg" class= "inim" id="imageInput"></div>
        <div class="order"><input type="submit" id="sumitee" name="add" value="Add Item"></div>
        </form>
    <script>
        function close12(){
        document.getElementById("sizesa").checked = false

        hide()
        document.getElementById("popform").classList.add("close");
    };
    function popup(){
        document.getElementById("popform").classList.remove("close");
        document.getElementById("popform").action ="additem.php?code=<?php echo"$code"?>&type=employee_rgo";
        document.getElementById("popform").innerHTML = `<button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
        <div><label for = "Code">Item Name: </label><input id="iteName" name='itemn' type="text" width="48" height="48"></div>
        <div><label for = "Size">Sizeable: </label><input onclick="hide()" id="sizesa" name='size' type="checkbox" name="Name" alt="Submit"></div>
        <div id="size" hidden><label for = "Size">Small Price: </label><input id="smallPrice" name='prices[0][price]'type="text" alt="Submit"><input hidden type="text" name="prices[0][size]" alt="Submit" value="Small">
        <label for = "Size">Medium Price: </label><input id="medPrice" name='prices[1][price]'type="text" alt="Submit"><input hidden type="text" name="prices[1][size]" alt="Submit" value="Medium">
        <label for = "Size">Large Price: </label><input id="largePrice"name='prices[2][price]'type="text" alt="Submit"><input hidden type="text" name="prices[2][size]" alt="Submit" value="Large">
        <label for = "Size">Custom Price: </label><input id="cusPrice"name='prices[3][price]'type="text" alt="Submit"><input hidden type="text" name="prices[3][size]" alt="Submit" value="Custom"></div>
        <div id="sizeprice"><label for = "Price">Price: </label><input id = 'nonePrice'name='price' type="text"></div>
        <label for = "image">Add Image: </label><input type="file" name="imgg" class= "inim" id="imageInput"></div>
        <div class="order"><input type="submit" id="sumitee" name="add" value="Add Item"></div>`
    };
    </script>
  <ul class="responsive-table">
  <table class="table custom-table">
  <thead>
    <tr>
    <th scope="col" class="searr"><label>Input Item Name:</label><input type="text" placeholder = "Blouse" id="itemname"class="text"><button type="button" onclick="search()" class="search"><ion-icon class = "icon"name="search-outline"></ion-icon></button></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th><input type="button" value="Add Item" class="button" onclick="popup()"></th>
</tr>
            <tr>
            <th scope="col">Item ID</th>
              <th scope="col" style="color:black;">Item</th>
              <th scope="col">Price</th>
              <th scope="col">Size</th>
              <th scope="col">Update</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
              <?php
                $code = $_GET['code'];
                $qry = "SELECT * FROM `item`;";
                $result = mysqli_query($conn, $qry);
                while($row= mysqli_fetch_assoc($result)){
                $item = $row['item'];
                echo "<tr scope='row' class='asd ".$row['item']."'>";
                echo "<td>".$row['Item_ID']."</td>";
                echo "<td style='color:black;'>".$row['item']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "<td>".$row['size']."</td>";
                echo "<td><button onclick=update('$item') name='update' type='button' class = 'button' id = 'templatebut2'class='templatebut'>Update</button></td>";
                echo "<td><form action='del.php?code=$code&item=$item' method='POST' onsubmit='return confirm(`Do you really want to delete the item : $item?`)'><button type='submit' class = 'button' id = 'templatebut2'class='templatebut' style='background-color:red; color:white;'>Delete</button></form></td>";
                echo "</tr>";
                }
                ?>
</div>
<script>
function hide(){
    if (document.getElementById('sizesa').checked == 1){
        document.getElementById("popform").classList.add("long");
        document.getElementById('popform').classList.remove("close")
        document.getElementById('sizeprice').hidden = true
        document.getElementById('size').hidden = false
    } else {
        document.getElementById('popform').classList.remove("long")
        document.getElementById('sizeprice').hidden = false
        document.getElementById('size').hidden = true
    }
    }
function search(){
    var itemN = document.getElementById('itemname').value;

    var els2 = document.getElementsByClassName('asd');
    for (var i = 0;i<els2.length ;i++){
        els2[i].style.display = "none";
    }
if (itemN == ""){
    var els2 = document.getElementsByClassName('asd');
    for (var i = 0;i<els2.length ;i++){
        els2[i].style.display = "table-row";
    }
}else{
    var els = document.getElementsByClassName(itemN);
    for (var i = 0;i<els.length ;i++){
        els[i].style.display = "table-row";
    }
}
}
function update(item){
    document.getElementById("popform").action ="updateitem.php?code=<?php echo"$code&"?>item="+item+""
    document.getElementById("popform").classList.remove("close");
    document.getElementById("sumitee").value = "Update Item";
    var items = document.getElementsByClassName(item)
    for (var i =0;i<items.length;i++){
       var ite = items[i].innerText.replace(/\s+/g, ',');
       ite = ite.split(',')
       console.log(ite)
       document.getElementById("iteName").value= ite['1']
        if(items.length == 1){
            document.getElementById("sizesa").checked = false
            document.getElementById("nonePrice").value= ite[2]
        }else{
            document.getElementById("sizesa").checked = true
            switch (ite[3]) {
                case "Small":
                    document.getElementById("smallPrice").value= ite[2]
                    break;
                case "Medium":
                    document.getElementById("medPrice").value= ite[2]
                    break;
                case "Large":
                    document.getElementById("largePrice").value= ite[2]
                    break;
                case "Custom":
                    document.getElementById("cusPrice").value= ite[2]
                    break;
            }
        }
    }
    hide()
    }

</script>
<?php include "../footer.php"; ?>