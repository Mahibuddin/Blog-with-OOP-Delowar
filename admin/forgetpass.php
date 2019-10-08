<?php
	include "../lib/Session.php";
	Session::checkLogin();
?>
<?php
	include "../config/config.php"; 
 	include "../lib/Database.php"; 
 	include "../helpers/Format.php"; 
 	$db = new Database();
 	$fm = new Format();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Password Recovery</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
	<body>
		<div class="container">
			<section id="content">
				<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$email = $fm->validation($_POST['email']);
						$email = mysqli_real_escape_string($db->link, $email);

						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							echo "<span class='error'>Invalid Email Address !!</span>";
						}else{
							$mailquery = "SELECT * FROM tbl_user WHERE email = '$email' limit 1";
                            $mailcheck = $db->select($mailquery);

							if ($mailcheck != false) {
								while ($value = $mailcheck->fetch_assoc()) {
									$userid   = $value['id'];
									$username = $value['username'];
								}

								$text 	  = substr($email, 0, 3);
								$rand 	  = rand(10000, 99999);
								$newpass  = "$text$rand";
								$password = md5($newpass);

								$updatequery = "UPDATE tbl_user 
				                    SET
				                    password  = '$password'
				                    WHERE id  = '$userid' ";

				                $updated_rows = $db->update($updatequery);

				                $to       = "$email";
				                $from     = "liveproject@gmail.com";
				                $headers  = "From: $from\n";
				                $headers .= 'MIME-Version: 1.0';
								$headers .= 'Content-type: text/html; charset=iso-8859-1';
								$subject  = "Your Password";
								$message  = "Your Username is".$username."and Password is".$newpass."Please visit website to login";

				                $sendmail = mail($to, $subject, $message, $headers);
				                if ($sendmail) {
				                	echo "<span class='success'>Please Check your Email for new password !!</span>";
				                }else{
				                	echo "<span class='error'>Email not sent !!</span>";
				                }

							}else{
								echo "<span class='error'>Email Not Exist !!</span>";
							}
						}
					}
				?>
				<form action="" method="post">
					<h1>Password Recovery</h1>
					<div>
						<input type="text" placeholder="Enter Valid Email"  name="email"/>
					</div>
					
					<div>
						<input type="submit" value="Send Email" />
					</div>
				</form><!-- form -->
				<div class="button">
					<a href="login.php">Login !</a>
				</div><!-- button -->

				<div class="button">
					<a href="#">Training with live project</a>
				</div><!-- button -->
			</section><!-- content -->
		</div><!-- container -->
	</body>
</html>