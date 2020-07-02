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
if (isset($_POST['d_name']) && isset($_POST['d_username']) && isset($_POST['pass']) && isset($_POST['cnfpass']))
{
   $name =$_POST['d_name'];
   $username = $_POST['d_username'];
   $password = $_POST['pass'];
   $cnf = $_POST['cnfpass'];
   $dob = $_POST['date'];
   $country = $_POST['country'];
   $specs = $_POST['area_specs'];
   $d_id = $_POST['d_id'];
   $desig = $_POST['desg'];
   $orgn = $_POST['org'];
// Create connection
  $con = mysqli_connect("localhost","root","","helora");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"insert into doctors (name,username,Password,Dob,country,specs,docid,desg,org) values ('$name','$username','$password','$dob','$country','$specs','$d_id','$desig','$orgn') ")
                                                                  or die("failed to query database".mysqli_error($con));

if ($result === TRUE) {
    echo "<script type='text/javascript'>alert('Profile created');</script>";
    //echo"'$name','$username','$password','$dob','$country','$specs','$d_id','$desig','$orgn'";
    header('Location: pre_login.php');

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    exit();

}
else {


  echo"no data<br>";

}
?>
</body>
</html>
