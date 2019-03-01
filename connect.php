<?php
  session_start();
  $con = mysqli_connect('localhost','root','','nanophp');

  function hash_generator($length = 8) {
      $characters = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }


  function validURL($url){
    $header = @get_headers($url);
    $str = $header[0];
    if(strpos($str,'200')){
      return true;
    }
    else{
      return false;
    }
  }

?>
