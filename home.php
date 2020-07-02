<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: lgin.php');
	exit();
}
//connecting to server and dbase

$con =  mysqli_connect("localhost","root","","helora");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
}
//Posts

$topics = mysqli_query($con,"select * from topics")
														or die("failed to query database".mysqli_error($con));
$num_top=mysqli_num_rows($topics);
$i = 1;

//question
if (isset($_POST['question']) && isset($_POST['topic_id']))
{
$question= $_POST['question'];
$topic_id = $_POST['topic_id'];
$username = $_SESSION['username'];
$feed = mysqli_query($con,"insert into questions(question,topic_id,asked_by) values('$question','$topic_id','$username') ")
															or die("failed to query database".mysqli_error($con));
if($feed === TRUE){

	echo '<script type="text/javascript">';
	echo 'alert("Aske")';
	echo "</script>";

	header("Location:". $_SERVER['REQUEST_URI']);
	exit();
}
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
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<link rel="shortcut icon" href="helora.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="style_profile.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="assets/css/style.css" rel="stylesheet" type="text/css">
	<!--Icon-->

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

	<a href="javascript:void(0);" class="icon">
<i class="fa fa-bars" onclick="openNav()"></i>
</a>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<h1>Helora</h1>
					<a href="home.php"><i class="fas fa-user-circle"></i>Home</a>
					<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>


			</div>
		</nav>
		<div class="content">
			<section class="cd-faq js-cd-faq container max-width-md margin-top-lg margin-bottom-lg">
				<!--Nav topic-->
				<ul class="cd-faq__categories">
				<li><a class="cd-faq__category cd-faq__category-selected" href="#organics" onclick="topic('1')">Organics</a></li>
				<li><a class="cd-faq__category" href="#cardio" onclick="topic('2')">Cardio</a></li>
				<li><a class="cd-faq__category" href="#ent" onclick="topic('3')">ENT</a></li>
				<li><a class="cd-faq__category" href="#neuro" onclick="topic('4')">Neuro</a></li>
				</ul> <!-- cd-faq__categories -->


				<!--nav topic end-->

      <ol class="cd-faq__items">

				<!--Ask question-->

								<form id="f<?php echo $n; ?>" style="margin-bottom: -25px; margin-top: 20px;" action="" method="post" enctype="multipart/form-data">
				<!--                                 <input type="button" value="Click here to answer." id="ans_b" >-->
													<textarea id="area<?php echo $n; ?>" name="question" position="fixed" style="resize:none" placeholder="Your Question..."></textarea>
													<br>
													<select class="dropDownSelect1" type="text" name="topic_id" placeholder="Specialization &nabla">

														<option value="1">Organics</option>
														<option value="2">Cardio</option>
														<option value="3">ENT</option>
														<option value="4">Neuro</option>
													</select>
													<br><br>
													<input type="submit" name="ansubmit" value="Post" class="up-in ans_sub" id="ar<?php echo $n; ?>">

											</form>
											<br>
											<br>
				<!--Queestion end-->
				<!--Posts-->

				<!--Organics 1-->
				 <ol id="organics" class="cd-faq__group">
				 <li class="cd-faq__title">
				 	<h2>
				 		<?php
						$i=1;
				 				$q="select * from topics where topic_id='$i'";
				 				$r = mysqli_query($con,$q)
				 											or die("failed to query database".mysqli_error($con));

				 				$d = mysqli_fetch_array($r);
				 				echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'].'</p></h2>';
				 		?>
				 	</h2></li>
				 	<!--Content-->
				 	<?php

				 			$qu = "select * from questions where topic_id='$i'";
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

				 								echo "<h4>".$a["answer"]."</h4>"."<small>Answered By: @".$a['answered_by']."</small>";
				 								echo "<br><br>";
				 						}
				 						else{

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
				 }
				 ?>
				 <!--UPVOTE ENDS-->
				 				</p>
				 			</div>
				 		</div>
				 	</li>
				  <br>
				 </ul>
				 	<?php }  ?>
					<!--Organics end-->

					<!--Cardio 2-->
					 <ol id="cardio" class="cd-faq__group">
					 <li class="cd-faq__title">
						<h2>
							<?php
							$i=2;
									$q="select * from topics where topic_id='$i'";
									$r = mysqli_query($con,$q)
																or die("failed to query database".mysqli_error($con));

									$d = mysqli_fetch_array($r);
									echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'].'</p></h2>';
							?>
						</h2></li>
						<!--Content-->
						<?php

								$qu = "select * from questions where topic_id='$i'";
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
					 }
					 ?>
					 <!--UPVOTE ENDS-->
									</p>
								</div>
							</div>
						</li>
						<br>
					 </ul>
						<?php }  ?>
						<!--Cardio end-->

						<!--ENT 3-->
						 <ol id="ent" class="cd-faq__group">
						 <li class="cd-faq__title">
							<h2>
								<?php
								$i=3;
										$q="select * from topics where topic_id='$i'";
										$r = mysqli_query($con,$q)
																	or die("failed to query database".mysqli_error($con));

										$d = mysqli_fetch_array($r);
										echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'].'</p></h2>';
								?>
							</h2></li>
							<!--Content-->
							<?php

									$qu = "select * from questions where topic_id='$i'";
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
						 }
						 ?>
						 <!--UPVOTE ENDS-->
										</p>
									</div>
								</div>
							</li>
							<br>
						 </ul>
							<?php }  ?>
							<!--ENT end-->
							<!--Neuro 4-->
							 <ol id="neuro" class="cd-faq__group">
							 <li class="cd-faq__title">
								<h2>
									<?php
									$i=4;
											$q="select * from topics where topic_id='$i'";
											$r = mysqli_query($con,$q)
																		or die("failed to query database".mysqli_error($con));

											$d = mysqli_fetch_array($r);
											echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'].'</p></h2>';
									?>
								</h2></li>
								<!--Content-->
								<?php

										$qu = "select * from questions where topic_id='$i'";
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
							 }
							 ?>
							 <!--UPVOTE ENDS-->
											</p>
										</div>
									</div>
								</li>
								<br>
							 </ul>
								<?php }  ?>
								<!--NEURO end-->



				<!--Posts end-->
</section>

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
