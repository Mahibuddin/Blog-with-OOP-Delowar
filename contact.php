<?php include "inc/header.php"; ?>

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$fname = $fm->validation($_POST['firstname']);
		$lname = $fm->validation($_POST['lastname']);
		$email = $fm->validation($_POST['email']);
		$body  = $fm->validation($_POST['body']);

		$fname = mysqli_real_escape_string($db->link, $fname);
		$lname = mysqli_real_escape_string($db->link, $lname);
		$email = mysqli_real_escape_string($db->link, $email);
		$body  = mysqli_real_escape_string($db->link, $body);

		$errorfn = "";
		$errorln = "";
		$errorem = "";
		$errorbd = "";

		if (empty($fname)) {
			$errorfn = "First Name must not be Empty ! ";
		}

		if (empty($lname)) {
			$errorln = "Last Name must not be Empty ! ";
		}

		if (empty($email)) {
			$errorem = "Email Name must not be Empty ! ";
		}

		if (empty($body)) {
			$errorbd = "Message Name must not be Empty ! ";
		

	/*	if (empty($fname)) {
			$error = "First Name must not be Empty ! ";
		}elseif (empty($lname)) {
			$error = "Last Name must not be Empty ! ";
		}elseif (empty($email)) {
			$error = "Email must not be Empty ! ";
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "Invalid Email Address ! ";
		}elseif (empty($body)) {
			$error = "Message field must not be Empty ! ";
		} */
		}else{

		$query = "INSERT INTO tbl_contact(firstname, lastname, email, body) VALUES('$fname', '$lname', '$email', '$body')";
                $inserted_rows = $db->insert($query);
                if ($inserted_rows) {
                    $msg = "Message has been sent Successfully. ";
                }else{
                    $error = "Message Not Sent ! ";
                }
		}
	}
?>

<style>
	.con-form-err{color: red; float: left;}
	.td-left{width: 25%; font-size: 18px;}
	.success{ color: green;font-size: 18px;font-weight: 600;padding: 10px 0;display: block;}
</style>


	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<h2>Contact us</h2>
				<?php
				/*
					if (isset($error)) {
						echo "<span style='color:red'>$error</span>";
					}  */

					if (isset($msg)) {
						echo "<span class='success'>$msg</span>";
					}  
				?>
			<form action="" method="post">
				<table>
					<tr>
						<td class="td-left">Your First Name:</td>
						<td>
							<?php 
								if (isset($errorfn)) {
									echo "<span class='con-form-err'>$errorfn</span>";
								}
							?>
						<input type="text" name="firstname" placeholder="Enter first name" />
						</td>
					</tr>
					<tr>
						<td class="td-left">Your Last Name:</td>
						<td>
							<?php 
								if (isset($errorln)) {
									echo "<span class='con-form-err'>$errorln</span>";
								}
							?>
						<input type="text" name="lastname" placeholder="Enter Last name" />
						</td>
					</tr>
					
					<tr>
						<td class="td-left">Your Email Address:</td>
						<td>
							<?php 
								if (isset($errorem)) {
									echo "<span class='con-form-err'>$errorem</span>";
								}
							?>
						<input type="text" name="email" placeholder="Enter Email Address" />
						</td>
					</tr>
					<tr>
						<td class="td-left">Your Message:</td>
						<td>
							<?php 
								if (isset($errorbd)) {
									echo "<span class='con-form-err'>$errorbd</span>";
								}
							?>
						<textarea name="body"></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
						<input type="submit" name="submit" value="Send"/>
						</td>
					</tr>
				</table>
			<form>				
 		</div>
	</div>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>