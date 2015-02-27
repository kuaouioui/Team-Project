<?php
  include('config.php');
  
  $id = $_GET['id'];
  
  $sql = "SELECT name, photo FROM barber WHERE id=$id";
  $result = mysql_query("$sql");
  $row = mysql_fetch_assoc($result);

  header("Content-type: image/jpeg");
  echo $row['photo'];
?>