


<?php
// To avoid people entering this page if they haven't logged in first
	if(!isset($_COOKIE['loggedin'])){
		header("location:login.html");
	}
?>

<!doctype html>

<html lang="en">

  <head>

    <title>Transparent Login Form with Bootstrap 4</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">

    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://m.w3newbie.com/you-tube.css">

  </head>

  <body>



    <div class="modal-dialog text-center">

      <div class="col-sm-8 main-section">

        <div class="modal-content">



          <div class="col-12 user-img">

            <img src="img/userpic.png">

          </div>



          <div class="col-12 textarea">

            <p>Invalid code entered, try again!</p>

            </div>



          <form class="col-12" action="second_login.php" method="POST">

            <div class="form-group">

            <input type="password" name="pin" maxlength="6" class="form-control" placeholder="Enter 6 Digit Code">

          </div>

          <button type="submit" class"btn"><i class="fas fa-sign-in-alt"></i>Login</button>

          </form>



          <div class="col-12 twofa">

            <a href="send_again.php">Try to send again</a>

            </div>





  </div>  <!--- end of modal content-->

</div>

</div>

    </body>

</html>