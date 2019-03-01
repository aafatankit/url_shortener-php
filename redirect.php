<?php
include 'connect.php';
$url = $_GET['url'];
$q = "select * from links where short = '$url'";
$result = mysqli_query($con,$q);
$avail = mysqli_num_rows($result);
if($avail == 1){
  $row = mysqli_fetch_array($result);
  $q1 = "update links set count = count + 1 where short = '$url'";
  mysqli_query($con,$q1);
  header('location:'.$row['original'].'');
}
else{
  $_SESSION['notification'] = 1;
  header('location:index.php');
}
?>
