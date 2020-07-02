<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: pre_login.php');
	exit();
}

$con = mysqli_connect("localhost","root","","helora");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
}
//Upvote
if (isset($_POST['like']))
{
	$ans = $_POST['ans_id'];
	$upv = $_SESSION['username'];
	$aby = $_POST['ansby'];

	$upvote = mysqli_query($con,"insert into upvotes(ans_id,upvote_val,upvoted_by,answered_by) values('$ans','1','$upv','$aby')");


	header("Location:". $_SERVER['REQUEST_URI']);
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
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="helora.png" />
		<link href="style_profile.css" rel="stylesheet" type="text/css">
			<link href="assets/css/style.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	</head>
	<body class="loggedin">
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="overlay-content">
<a href="home.php">Home</a><br>
<a href="profile.php">Profile</a><br>
<a href="logout.php">Logout</a><br>
</div>
</div>
		<nav class="navtop" id="navtopid">
			<div>
				<h1>Helora</h1>
					<a href="home.php"><i class="fas fa-user-circle"></i>Home</a>
					<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				<a href="javascript:void(0);" class="icon">
    <i class="fa fa-bars" onclick="openNav()"></i>
  </a>

			</div>
		</nav>
		<div class="content">
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
				</table>
			</div>
			<center><h2>The Questions you asked.</h2></center>
			<!--Your feeds-->
							<section class="cd-faq js-cd-faq container max-width-md margin-top-lg margin-bottom-lg">
			      <ol class="cd-faq__items">
			<?php

					$n=$_SESSION['username'];
					$qu = "select * from questions where asked_by='$n'";
					$re = mysqli_query($con,$qu);
					while($da = mysqli_fetch_array($re)){
			?>

		 <li class="cd-faq__item">
			<a class="cd-faq__trigger" href="#"><span><?php echo $da['question']."<br><small id='sml'>Asked By: @".$da['asked_by']."</small>"; ?></span></a>
				<div class="cd-faq__content">
				<div class="text-component">
					<p><?php
					$ans = "select * from answers where q_id='$da[q_id]'";
					$an = mysqli_query($con,$ans);
						while ($a= mysqli_fetch_array($an)) {
								if($a["answer"]){
										//print_r($row);
										$nul=0;
										echo "<h4>".$a["answer"]."</h4>"."<small>Answered By: @".$a['answered_by']."</small>";
										echo "<br><br>";


								}
								else{
										$nul=1;
										echo "<em>*** Not Answered Yet ***</em>";
								}?>


		 <form id="likeform" method="post" action="">

		 <input style="display: none;" name="ans_id" value="<?php echo $a['ans_id'] ?>">
		 <input style="display: none;" name="ansby" value="<?php echo $a['answered_by'] ?>">
		 <button type="submit" class="vote" id="like" onclick="setcolor()" name="like"><i class="fas fa-arrow-up"></i></button>

		 <?php
		 //echo "<h6>"."$count_vote"."</h6>";
		 $ans = $a['ans_id'];
		 $count_vote = mysqli_query($con,"select * from upvotes where ans_id='$ans'");
		 echo "&nbsp".mysqli_num_rows($count_vote)."&nbspupvotes";
		 echo "<br><br>";
		 ?>
		 </form>
		 <?php
	 }}
		 ?>

		 <!--UPVOTE ENDS-->
						</p>
					</div>
				</div>
			</li>
			</ol>
		</section>
		Developed By : Mohamed Tariq S
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
