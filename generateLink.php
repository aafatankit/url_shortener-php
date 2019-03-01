<?php
include 'connect.php';

if(!isset($_POST['link'])){
  header('location:index.php');
}

$url = $_POST['link'];
$total = count($url);

$_SESSION['shortlink'] = 1;
for($i = 0; $i < $total; $i++){
  if(validURL($url[$i])){
    $que = "select * from links where original = '$url[$i]'";
    $answer = mysqli_query($con,$que);
    $present = mysqli_num_rows($answer);
    if($present > 0){
      $index = mysqli_fetch_array($answer);
      $_SESSION['shortlink'] = $_SESSION['shortlink'].'/'.$index['short'];
    }
    else{
      do{
        $hash = hash_generator();
        $q = "select * from links where short = '$hash'";
        $result = mysqli_query($con,$q);
        $avail = mysqli_num_rows($result);
      }while($avail != 0);

      $url[$i] = str_replace("'","\'", $url[$i]);
      $url[$i] = str_replace('"','\"', $url[$i]);

      $q1 = "insert into links(short,original) values('$hash','$url[$i]')";
      mysqli_query($con,$q1);
      $_SESSION['shortlink'] = $_SESSION['shortlink'].'/'.$hash;
    }
  }
  else{
    $_SESSION['shortlink'] = $_SESSION['shortlink'].'/404';
  }

}

// $_SESSION['shortlink'] = explode('/',$_SESSION['shortlink']);
// print_r($_SESSION['shortlink']);
// echo '<br>';
// echo count($_SESSION['shortlink']);
//echo $_SESSION['shortlink'];
header('location:index.php');

?>
