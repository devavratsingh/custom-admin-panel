
<?php
ob_start();
session_start();
require("app/config/database.php");
if(isset($_SESSION['username']) & !empty($_SESSION['username'])){
  header("location: index.php");
}

 if (isset($_COOKIE['username']))
    {
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['logged_in'] = 1;
        header('location: index.php');
    }

    if (isset($_POST) && !empty($_POST))
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
        //3.1.2 Checking the values are existing in the database or not
        $query = "SELECT * FROM `users` WHERE mr_art_export_username='$username' and mr_art_export_password='$password'";
         
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
        if ($count === 1){
        $_SESSION['username'] = $username;
        header('location: index.php');
        }else{
        //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        $fmsg = "Invalid Login Credentials.";
        }
        }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name='robots' content='noindex,nofollow' />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Sat Sai Infocom">
    <meta name="generator" content="SAT SAI INFOCOM">
    <title>Signin Admin - MR ART Exports</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signin.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin shadow-lg bg-white rounded" action="" method="post">
      <img src="../images/logo.png" width="200px">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="input" id="inputUsername" class="form-control" name="username" placeholder="Enter Username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="myfunctionCalled()">Sign in</button>
      <p class="mt-5 mb-3 text-muted"><a href="https://www.satsaiinfocom.com" title="Sat Sai Infocom" target="_blank">SAT SAI INFOCOM </a>&copy; 2018-2019</p>
    </form>
    <script>
    myfunctionCalled = () => {
      setTimeout(function()
      { 
        window.location = "index.php"; 
      }, 1000);
    }
</script>
</body>
</html>
<?php ob_end_flush(); ?>
