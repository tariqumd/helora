<html>

<head>
  <meta charset="utf-8">

    <meta name="viewport" content="width=device-width">
<title>
login
</title>
<link rel="shortcut icon" href="logo.png" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<style>
body {


  color: black;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  z-index: 5;
  width: 100%;
  max-width: 50%;
  padding: 20px;
  text-align: center;
  font-family: cursive;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<body>
  <div class="bg-image1"></div>
  <div class="bg-con1" id="content">

<?php

      session_start();
    //getting value from form
      $username = $_POST['user'];
      $password = $_POST['pass'];
    //PREVENTING SQL INJECTION

    $username = stripcslashes($username);
    $password = stripcslashes($password);
//   $username = mysqli_real_escape_string($username);
  //  $username = mysqli_real_escape_string($password);

    //connecting to server and dbase

    $con = mysqli_connect("localhost","root","","helora");
  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
    }
    //query the db for user

    $result = mysqli_query($con,"select * from users where username ='$username' and password = '$password' ")
                        or die("failed to query database".mysqli_error($con));

    $row = mysqli_fetch_array($result);

    if($row['username']==$username && $row['password']==$password)
    {
        echo"<h1><center><br>Loging In...<br><br>"; //Welcome  ".$row['username'];
        echo"<br><br><div class='loader'></div>";
        session_regenerate_id();
		      $_SESSION['loggedin'] = TRUE;
		        $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $row['username'];
		          $_SESSION['id'] = $row['uid'];
                $_SESSION['pwd'] = $row['password'];
                $_SESSION['date'] = $row['dob'];
                  $_SESSION['country'] = $row['country'];
                  $_SESSION['doc'] = $row['doctor'];

		            echo 'Welcome ' . $_SESSION['name'] . '!';
                echo"<br>ID-NO" . $_SESSION['id'];
                header("Location: profile.php");
        exit();
    }
    else
    {
        echo "Wrong Credentials";
        /*echo "<script type='text/javascript'>alert(<?php echo $message;?>);
           </script>";
*/

    }
 ?>
</body>
</html>
