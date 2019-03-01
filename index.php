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
        <div style="background-color: #04356F;">
          <div class="container">
            <br><br>
            <h1 class="text-white">Simplify Your Links</h1>
            <p class="text-white">All shorter links can be accessed by anyone.</p>
            <form action="generateLink.php" method="POST">
              <div class="row">
                <div class="col-md-7" id="addlink">
                    <input type="text" name="link[]" class="form-control" placeholder="Paste Your Original URL here.." required>
                    <a href="#" class="btn btn-success btn-sm float-right" id="add">Add More</a>
                </div>
                <div class="col-md-2">
                  <input type="submit" value="Get Shorter Link" class="btn btn-danger">

                </div>
                <div class="col-md-3">
                </div>
              </div>
              </form>
              <br><br><br>
          </div>
        </div>


        <div class="modal" id="showlink">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title">Successfully</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                Here is Your Short Link.<br>

                <?php
                  $_SESSION['shortlink'] = explode('/',$_SESSION['shortlink']);
                  $total = count($_SESSION['shortlink']);
                  for($i = 1; $i < $total; $i++){
                    if($_SESSION['shortlink'][$i] == 404){
                      echo '<i class="text-danger" id="slink">Link '.$i.' : Invalid/Bad Request</i><br>';
                    }
                    else{
                      echo '<i class="text-primary" id="slink">Link '.$i.' : <a href="http://nan0.ml/'.$_SESSION['shortlink'][$i].'" target="_blank">nan0.ml/'.$_SESSION['shortlink'][$i].' <i class="fa fa-share-square-o"></i></a></i><br>';
                    }
                  }
                  unset($_SESSION['shortlink']);
                 ?>

               <!-- <button onclick="copy()" class="btn"><i class="fa fa-copy"></i></button> -->
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
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
        <div class="text-right container">
          <a href="original.php" class="btn btn-info">Original Links</a>
        </div>
        <div class="container table-responsive">

          <br>
          <h4>Recently Added Links</h4>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Original URL</th>
                <th>Short URL</th>
                <th>All Clicks</th>
              </tr>
            </thead>
            <?php
            $q = "select * from links order by id desc";
            $result = mysqli_query($con,$q);
            echo '<tbody>';
            while($row = mysqli_fetch_array($result)){
              echo '<tr>';
                echo '<td class="col1 text-primary">';
                custom_echo($row['original'], 90);
                echo '</td>';
                echo '<td class="col2 text-success"><i><a href="http://nan0.ml/'.$row['short'].'" class="text-success" target="_blank">nan0.ml/'.$row['short'].' <i class="fa fa-share-square-o"></i></a></i></td>';
                echo '<td class="col3 text-center">'.$row['count'].'</td>';
              echo '</tr>';
            }
            echo '</tbody>';
            ?>
          </table>
        <div>

      </div>
      <script>
        function copy(){
          var shortlink = document.getElementById('slink');
          var range = document.createRange();

          range.selectNode(shortlink);
          window.getSelection().addRange(range);
          document.execCommand('copy');
        }
      </script>
      <script>
          $(document).ready(function(e){
              var link='<div><br><input type="text" name="link[]" class="form-control" placeholder="Paste Your Original URL here.." required><a href="#" class="btn btn-danger btn-sm float-right" id="remove"> &times; </a></div>';
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
