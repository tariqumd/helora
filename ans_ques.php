<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: lgin.html');
	exit();
}
//connecting to server and dbase

$con = mysqli_connect("localhost","root","","helora");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
}
//query the db for user

//$result = mysqli_query($con,"select * from users where username ='$username' and password = '$password' ")
	//									or die("failed to query database".mysqli_error($con));

//$row = mysqli_fetch_array($result);
if (isset($_POST['qu_id']) && isset($_POST['answer']) && isset($_POST['ansby']))
{
$qu_id= $_POST['qu_id'];
$answer = $_POST['answer'];
$ans_by = $_POST['ansby'];
$feed = mysqli_query($con,"insert into answers(q_id,answer,answered_by) values('$qu_id','$answer','$ans_by') ")
															or die("failed to query database".mysqli_error($con));
if($feed === TRUE){

	echo '<script type="text/javascript">';
	echo 'alert("Answered")';
	echo "</script>";

	header("Location:". $_SERVER['REQUEST_URI']);
	exit();
}
}
?>



<!DOCTYPE html>
<html>
	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>Profile</title>
		<link rel="shortcut icon" href="helora.png" />
		<link href="style_profile.css" rel="stylesheet" type="text/css">
		<script>document.getElementsByTagName("html")[0].className += " js";</script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="assets/css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="overlay-content">
<a href="home_doc.php">Answer_Question</a><br>
<a href="profile.php">Profile</a><br>
<a href="logout.php">Logout</a><br>
</div>
</div>
		<nav class="navtop" id="navtopid">
			<div>
				<h1>Helora</h1>
					<a href="ans_ques.php"><i class="fas fa-user-circle"></i>Answer</a>
					<a href="home_doc.php"><i class="fas fa-user-circle"></i>Home</a>
					<a href="doc_profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				<a href="javascript:void(0);" class="icon">
    <i class="fa fa-bars" onclick="openNav()">Menu</i>
  </a>
</div>
</nav>
		<section class="cd-faq js-cd-faq container max-width-md margin-top-lg margin-bottom-lg">
			<ul class="cd-faq__categories">
				<li><a class="cd-faq__category cd-faq__category-selected truncate" href="#organics"><?php echo $_SESSION['specs']; ?></a></li>


			</ul> <!-- cd-faq__categories -->
      <?php
					$sp=$_SESSION['specs'];
        	$sql_top = mysqli_query($con,"select * from topics where topic='$sp'")
																									or die("failed to query database".mysqli_error($con));
					$ar_top = mysqli_fetch_array($sql_top);
					$no = $ar_top['topic_id'];
          $n = 1;
          $nul=0;
          while($n < 2 ){
      ?>
			<!--Topics-->
      <ol class="cd-faq__items">
				<ul id="organics" class="cd-faq__group">
				<li class="cd-faq__title">
					<h2>
						<?php
								$q="select * from topics where topic_id='$no'";
								$r = mysqli_query($con,$q)
															or die("failed to query database".mysqli_error($con));

								$d = mysqli_fetch_array($r);
								echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'].'</p></h2>';
						?>
					</h2></li>
					<!--Content-->
					<?php
							$qu = "select * from questions where topic_id='$no'";
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
									if($a["answer"])
									{
									$nul=0;
												echo "<h4>".$a["answer"]."</h4>"."<small>Answered By: @".$a['answered_by']."</small>";
												echo "<br><br>";

										}
										else{
												$nul=1;
												echo "<em>*** Not Answered Yet ***</em>";
										}
									}
								?>
								</p>
								<form id="f<?php echo $n; ?>" style="margin-bottom: -25px;" action="" method="post" enctype="multipart/form-data">
<!--                                 <input type="button" value="Click here to answer." id="ans_b" >-->
                          <textarea id="area<?php echo $n; ?>" name="answer" placeholder="Your Answer..."></textarea>
                          <input style="display: none;" name="qu_id" value="<?php echo $da['q_id'] ?>">
                          <input style="display: none;" name="ansby" value="<?php echo $_SESSION['username'] ?>">
                          <br><br>
                          <input type="submit" name="ansubmit" value="Submit" class="up-in ans_sub" id="ar<?php echo $n; ?>">

                      </form>
											<br>
		          </div>
						</div>
					</li>
					<br>
				</ul>
					<?php $n++; } ?>


	<?php
			$no++;
	}
	?>
							</ol>

<a href="#0" class="cd-faq__close-panel text-replace">Close</a>
<div class="cd-faq__overlay" aria-hidden="true"></div>


</section> <!-- cd-faq -->
<script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="assets/js/main.js"></script>

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
