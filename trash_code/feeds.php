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

?>



<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="helora.png" />
<link href="style_profile.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="js_feed/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js_feed/script.js"></script>
<link type="text/css" rel="stylesheet" href="css_feed/style.css">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top:70px;
  left: 0;
  background-color: black;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main,.main2{
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


</style>
</head>
<body>
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
        <a href="home.php"><i class="fas fa-user-circle"></i>home</a>
					<a href="feeds.php"><i class="fas fa-user-circle"></i>Topics</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				<a href="javascript:void(0);" class="icon">
    <i class="fa fa-bars" onclick="openNav()">Menu</i>
  </a>

			</div>
		</nav>


<div class="sidenav">
  <div id="cont" class="sidenav">
              <div id="box0">
                      <a id="ada" href="#box1">
  										Organics
                      </a>
  										<br>
                      <a id="cso" href="#box2">
  										Dermatology
  										</a>
  										<br>
                      <a id="t" href="#box3">
  										Cardio
                      </a>
              </div>
  		</div>
</div>

<div class="main">
  <center>
      <?php
          $no = 1;
          $n = 1;
          $nul=0;
          while($no < 4){
      ?>
      <div id="box<?php echo $no; ?>" class="open">
          <a href=""><div id="close">X</div></a>
          <div id="topic">
              <?php
                  echo "$no.";
                  echo "<h2 id='topic-head'>";

                  $q="select * from topics where topic_id='$no'";
                  $r = mysqli_query($con,$q)
                                or die("failed to query database".mysqli_error($con));

                  $d = mysqli_fetch_array($r);
                  echo $d['topic'].'</h2><p id="topic-desc">'.$d['descp'];
              ?>
          </div>

          <center>
              <?php
                  $qu = "select * from questions";
                  $re = mysqli_query($con,$qu);
                  while($da = mysqli_fetch_array($re)){
              ?>
              <div id="qa-block">
                  <div class="question">
                      <div id="Q">Q.</div>
                      <?php echo $da['question']."<small id='sml'>Asked By: @".$da['asked_by']."</small>"; ?>
                  </div>
                  <div class="answer">
                      <?php
                          if($da["answer"]){
                              $nul=0;
                              echo $da["answer"]."<br><small>Answered By: @".$da['answered_by']."</small>";
                          }
                          else{
                              $nul=1;
                              echo "<em>*** Not Answered Yet ***</em>";
                          }
                      ?>
                      <form id="f<?php echo $n; ?>" style="margin-bottom: -25px;" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] ); ?>" method="post" enctype="multipart/form-data">
<!--                                    <input type="button" value="Click here to answer." id="ans_b" >-->
                          <label style="margin-bottom: -25px;"><a id="ans_b<?php echo $n; ?>" href="#area<?php echo $no; ?>"><u>Submit your answer</u></a></label>
                          <br>
                          <script>
                              $(function(){
                                  $('#ans_b<?php echo $n; ?>').click(function(e){
                                      e.preventDefault();
                                      $('#area<?php echo $n; ?>').css("display","block");
                                      $('#ar<?php echo $n; ?>').css("display","block");
                                      $('#f<?php echo $n; ?>').css("margin-bottom","0px");
                                  });
                              });
                          </script>
                          <textarea id="area<?php echo $n; ?>" name="answer" placeholder="Your Answer..."></textarea>
                          <input style="display: none;" name="question" value="<?php echo $da['question'] ?>">
                          <input style="display: none;" name="nul" value="<?php echo $nul ?>">
                          <input style="display: none;" name="preby" value="<?php echo $da['answeredby'] ?>">
                          <br>
                          <input type="submit" name="ansubmit" value="Submit" class="up-in ans_sub" id="ar<?php echo $n; ?>">

                      </form>



                  </div>
              </div>
              <?php $n++; } ?>
          </center>

      </div><!-- box1 -->
      <?php
          $no++;
      }
      ?>
  </center>

</div><!-- content -->

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
