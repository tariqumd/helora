<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: pre_login.php');
	exit();
}
$con = mysqli_connect("localhost","root","","helora");

if (mysqli_connect_errno()) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}


$usr = $_SESSION['username'];
$rating = mysqli_query($con,"select * from upvotes where answered_by='$usr'");
$star_val = mysqli_num_rows($rating);
//CODE Check
/*
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT username, name , password FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($name, $password);
$stmt->fetch();
$stmt->close();*/
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile</title>
		<link rel="shortcut icon" href="helora.png" />
		<link href="style_profile.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

	</head>
	<body class="loggedin">
		<div id="myNav" class="overlay">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<div class="overlay-content">
		<a href="feeds.php">Home</a><br>
		<a href="doc_profile.php">Profile</a><br>
		<a href="logout.php">Logout</a><br>
		</div>
		</div>
		<nav class="navtop">
			<div>
				<h1>Helora</h1>
				<a href="ans_ques.php"><i class="fas fa-user-circle"></i>Answer</a>
					<a href="home_doc.php"><i class="fas fa-user-circle"></i>Home</a>
				<a href="doc_profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				<a href="javascript:void(0);" class="icon">
		<i class="fa fa-bars" onclick="openNav()"></i>
		</a>
			</div>
		</nav>
		<div class="content">
			<h4 style="float:right">
	<?php
			 if($star_val>0 and $star_val<=10)
			{
			 echo '<img src="img/star.png" height=30px width=30px>';
		 }
		 else if($star_val>10 and $star_val<=20)
		 {
				echo '<img src="img/star.png" height=30px width=30px>';
				echo '<img src="img/star.png" height=30px width=30px>';

		 }
		 else if($star_val>20 and $star_val<=30)
		 {
			 echo '<img src="img/star.png" height=30px width=30px>';
			 echo '<img src="img/star.png" height=30px width=30px>';
			echo '<img src="img/star.png" height=30px width=30px>';
		 }
		 else if($star_val>30 and $star_val<=40)
		 {
			 echo '<img src="img/star.png" height=30px width=30px>';
			 echo '<img src="img/star.png" height=30px width=30px>';
			echo '<img src="img/star.png" height=30px width=30px>';
				echo '<img src="img/star.png" height=30px width=30px>';
		 }
		 else if($star_val>40)
		 {
			 echo '<img src="img/star.png" height=30px width=30px>';
			 echo '<img src="img/star.png" height=30px width=30px>';
			echo '<img src="img/star.png" height=30px width=30px>';
				echo '<img src="img/star.png" height=30px width=30px>';
				echo '<img src="img/star.png" height=30px width=30px>';

		 }

			 ?>
		 </h4>
			<h2>Profile Page</h2>
			<p>Welcome back,<b> <?=$_SESSION['name']?>!</b></p>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>User ID:</td>
						<td><?=$_SESSION['id']?></td>
					</tr>
					<tr>
						<td>User Name:</td>
						<td><?=$_SESSION['username']?></td>
					</tr>
					<tr>
						<td>Name:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$_SESSION['pwd']?></td>
					</tr>
					<tr>
						<td>Date of Birth:</td>
						<td><?=$_SESSION['date']?></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><?=$_SESSION['country']?></td>
					</tr>
					<tr>
						<td>Specilization:</td>
						<td><?=$_SESSION['specs']?></td>
					</tr>
					<tr>
						<td>Doctor_ID:</td>
						<td><?=$_SESSION['docid']?></td>
					</tr>
					<tr>
						<td>Designation:</td>
						<td><?=$_SESSION['desg']?></td>
					</tr>
					<tr>
						<td>Organisation:</td>
						<td><?=$_SESSION['org']?></td>
					</tr>
				</table>
			</div>
		</div>
		<script>
		function myFunction() {
		  var x = document.getElementById("navtopid");
		  if (x.className === "navtop") {
		    x.className += " responsive";
		  } else {
		    x.className = "navtop";
		  }
		}
function openNav() {
  		document.getElementById("myNav").style.width = "100%";
		}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
		</script>
	</body>
</html>
