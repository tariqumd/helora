<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: lgin.html');
	exit();
}
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	</head>
	<body class="loggedin">
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="overlay-content">
<a href="feeds.php">Feeds</a><br>
<a href="profile.php">Profile</a><br>
<a href="logout.php">Logout</a><br>
</div>
</div>
		<nav class="navtop" id="navtopid">
			<div>
				<h1>Helora</h1>
					<a href="Topics.php"><i class="fas fa-user-circle"></i>Topics</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				<a href="javascript:void(0);" class="icon">
    <i class="fa fa-bars" onclick="openNav()"></i>
  </a>

			</div>
		</nav>
		<div class="content">
			<h2>Topics:</h2>
			<div>
				<a href="#"><b>Organics</b></a>
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
