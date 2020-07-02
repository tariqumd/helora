<?php
// We need to use sessions, so you should always start sessions using the below code.

$con = mysqli_connect("localhost","root","","helora");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
}
if (isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['message']))
{

$name = $_POST['fname'];
$email = $_POST['email'];
$message = $_POST['message'];

$query = mysqli_query($con,"insert into queries(Name,mail_id,message)values('$name','$email','$message')")
                                          or die("failed to query database".mysqli_error($con));

if($query===TRUE)
{
header("Location:index.html");
exit();
}
else{
  echo "Error adding query";
}
}
else{

  echo "Enter the data";
}

?>
