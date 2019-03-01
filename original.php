<?php
include 'connect.php';
function custom_echo($x, $length){
  if(strlen($x)<=$length){
    echo $x;
  }
  else{
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}

function checkShort($str){
  $str = explode('/',$str);
  $count = count($str);
  if($count > 4){
    return false;
  }
  else{
    if(($str[0] == 'http:' || $str[0] == 'https:') && ($str[2] == 'nan0.ml' || $str[2] == 'www.nan0.ml') && ($count == 4)){
      return true;
    }
    else if(($str[0] == 'nan0.ml' || $str[0] == 'www.nan0.ml') && ($count == 2)){
      return true;
    }
    else{
      return false;
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tripoto Assignment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body{
      font-family: 'Josefin Sans', sans-serif;
      	/* #04356F
        #36a82b */
    }
    .col1{
      width: 70%;
    }
    .col2{
      width: 20%;
    }
    .col3{
      width: 10%;
    }
    a#logo{
       outline:none;
    }
    a#logo{
      text-decoration:none;
    }
    </style>
    <?php
    if(isset($_SESSION['shortlink'])){
      echo '<script>';
          echo '$(document).ready(function(){';
              echo '$("#showlink").modal("show");';
          echo '});';
      echo '</script>';
    }
    if(isset($_SESSION['notification'])){
      echo '<script>';
          echo '$(document).ready(function(){';
              echo '$("#invalid").modal("show");';
          echo '});';
      echo '</script>';
      unset($_SESSION['notification']);
    }
    ?>
  </head>
  <body>
      <div>
        <div class="container">
          <br>
          <h2><a href="index.php" id="logo" class="text-dark"><i class="text-success">nano</i> URL Shortener</a></h2>
        </div>
        <div style="background-color: #82080A;">
          <div class="container">
            <br><br>
            <h1 class="text-white">Get Your Original Links</h1>
            <div>
              <a href="original.php" class="btn btn-info">Reset</a>
              <a href="index.php" class="btn btn-warning">Back to Home</a>
            </div>
            <br>
            <!-- <p class="text-white">All shorter links can be accessed by anyone.</p> -->
            <form action="" method="POST">
              <div class="row">
                <div class="col-md-7" id="addlink">
                    <input type="text" name="link[]" class="form-control" placeholder="e.g: nan0.ml/vwXnVBhu" required autocomplete="off">
                    <a href="#" class="btn btn-success btn-sm float-right" id="add">Add More</a>
                </div>
                <div class="col-md-2">
                  <input type="submit" value="Get Original Link" class="btn btn-primary">

                </div>
                <div class="col-md-3">

                </div>
              </div>
              </form>
              <br><br><br>
          </div>
        </div>


        <div class="modal" id="invalid">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title">Error 404 Not Found !</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                The URL you are looking for may be Expired or Invalid.
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
        <br><br><br>
      </div>

      <?php
      if(isset($_POST['link'])){
        echo '<div class="container">';
        echo '<h1>Original Links</h1>';
        echo '<hr>';
        $short = $_POST['link'];
        $count = count($short);
        for($i = 0; $i < $count; $i++){
          $url = $short[$i];
          $url = explode('/',$url);
          $index = count($url);
          $hash = $url[$index - 1];
          $q = "select * from links where short = '$hash'";
          $result = mysqli_query($con,$q);
          $avail = mysqli_num_rows($result);
          if(($avail == 1) && (checkShort($short[$i]))){
            echo '<h4>Short URL : <i class="text-success">'.$short[$i].'</i></h4><br>';
            $row = mysqli_fetch_array($result);
            echo '<h4>Original URL : <i class="text-primary">'.$row['original'].'</i></h4><br>';
            echo '<hr>';
          }
          else{
            echo '<h4>Short URL : <i class="text-danger">'.$short[$i].'</i></h4><br>';
            echo '<h4>Original URL : <i class="text-danger">Not Found/Invalid URL/Expired</i></h4><br>';
            echo '<hr>';
          }
        }
        echo '</div>';
      }
      ?>

      <script>
          $(document).ready(function(e){
              var link='<div><br><input type="text" name="link[]" class="form-control" placeholder="e.g: nan0.tk/vwXnVBhu" required><a href="#" class="btn btn-danger btn-sm float-right" id="remove"> &times; </a></div>';
              $('#add').click(function(e){
                  $("#addlink").append(link);
              });

              $('#addlink').on('click','#remove',function(e){
                  $(this).parent('div').remove();
              });
          });
        </script>
  </body>
</html>
