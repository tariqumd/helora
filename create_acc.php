<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">

    <meta name="viewport" content="width=device-width">
<title>
User_Registration
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

<?php
if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['cnfpass']))
{
   $name = $_POST['name'];
   $username = $_POST['username'];
   $password = $_POST['pass'];
   $cnf = $_POST['cnfpass'];
   $dob = $_POST['date'];
   $country = $_POST['country'];

// Create connection
  $con = mysqli_connect("localhost","root","","helora");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"insert into users (username,name,password,dob,country) values ('$username','$name','$password','$dob','$country') ")
                                                                  or die("failed to query database".mysqli_error());

if ($result === TRUE) {
    echo "<script type='text/javascript'>alert('Profile created');</script>";
    header('Location: lgin.html');

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    exit();

}else {


  echo"no data";
}
?>
</body>
</html>
