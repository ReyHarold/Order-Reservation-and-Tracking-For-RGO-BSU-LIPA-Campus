<?php
//server with default setting (user 'root' with no password)
$host = 'localhost';  // server 
$user = 'root';   
$pass = "";   
$database = 'db_sm3101';   //Database Name  

// establishing connection
  $conn = mysqli_connect($host,$user,$pass,$database);   

 // for displaying an error msg in case the connection is not established
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

// Safe request readers: return the value if present, otherwise a default.
// Avoids PHP 8 "Undefined array key" warnings, which would otherwise print
// output before header() redirects and re-trigger "headers already sent".
function g($key, $default = '') {
    return isset($_GET[$key]) ? $_GET[$key] : $default;
}
function p($key, $default = '') {
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}
?>