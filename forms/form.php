<?php
session_start();
include 'default.php';
// include 'forms/helpers.php';

function send_mail($username, $firstname, $lastname, $email, $hash, $type) {		//	Send email to Registerd user
	$to      = $email; // Send email to our user
	$headers = 'From:noreply@comagaru.com' . "\r\n"; // Set from headers

	if ($type == "user details") {		//	change user details
		$subject = "Your Camagaru user details have been changed";
		$message = "Your account has successfully been created";
	}
	if ($type == "new user") {		//	
		$subject = 'Signup | Verification'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
		$message = '
		
	   Thanks for signing up!
	   Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
		
	   ------------------------
	   username: '.$username.'
	   First Name: '.$firstname.'
	   Last Name: '.$lastname.'
	   Email: '.$email.'
	   Password: ...just kidding, thats a serurity risk.
	   ------------------------
		
	   Please click this link to activate your account:
	   http://127.0.0.1:8080/camagru/verify.php?email='.$email.'&hash='.$hash.'
	   '; // Our message above including the link
	}
	if ($type == "user login") {	//	if user login
		$subject = 'Signin | Notification'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
		$message = '
		
		Account accessed

		Hi '.$username.',

		Your account has been accessed. Please let us know if this was not done by you.

	   '; // Our message above including the link
	}
	if ($type == "reset_password") {		//	
		$subject = 'Reset Password'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
		$message = '
		
	   Someone said you forgot your password. If it was not you, please ignore this email.
	   If it was you, click the link below to reser your password.

	   ------------------------
		
	   Please click this link to activate your account:
	   http://127.0.0.1:8080/camagru/reset_password.php?email='.$email.'&hash='.$hash.'
	   '; // Our message above including the link
	}
	mail($to, $subject, $message, $headers);
}

try
{
	//	conect to database  to be able to execute CRUD opperations
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	/****************************/
	/*		reset password		*/
	/****************************/
	if ($_POST['reset_password']) {
		echo "reseting password<br>";
		if((trim($_POST['reset_email']) != "") && (trim($_POST['password1']) != "") && (trim($_POST['password2']) != "")){
			echo "reseting password:: elements found<br>";
			if ($_POST['password1'] === $_POST['password2']) {
			echo "Passwords maatch<br>";
				try{
					$email = $_POST['reset_email'];
					$psword = strtoupper(hash('whirlpool' , $_POST['password1']));
					$stmt = $conn->prepare("UPDATE $usrsTB SET pssword=:pssword WHERE email=:email" );
					$stmt->bindParam(':pssword', $psword);
					$stmt->bindParam(':email', $email);
					$stmt->execute();
					header("Location: ../login.php");
				}catch(PDOException $e) {
					echo "Forget Error: " . $e->getMessage() . "<br>";
					header("Location: ../reset_password.php");
				}
			} else {
				echo 'passwords dont match';
				header("Location: ../reset_password.php");
			}
		}else {
			echo 'Password empty<br>';
			header("Location: ../reset_password.php");
		}
	}

	/****************************/
	/*		forgot password		*/
	/****************************/
	if ($_POST['forgot_password']) {
		if (trim($_POST['reset_email']) != "") {		//	check if user is registerd/valid
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
			$email = $_POST['reset_email'];
			$query->bindParam(':email', $email);
			$query->execute();

			if ($count = count($query) == 1 ) 
			{	// Find out if email already exists in database (IF USER EXISTS)
				$result = $query->fetch(PDO::FETCH_ASSOC);
				$username	= $result['username'];
				$firstname	= $result['firstname'];
				$lastname	= $result['lastname'];
				$email		= $result['email'];
				try {
					$confirm = hash(md5 ,rand());
					// prepare sql and bind parameters
					$stmt = $conn->prepare("UPDATE $usrsTB SET confirm=:confirm WHERE email=:email");
					$stmt->bindParam(':confirm', $confirm);
					$stmt->bindParam(':email', $email);
					$stmt->execute();

					echo "Please check your email successfully";
					$_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
					$_SESSION['type'] = 'success';
					send_mail($username, $firstname, $lastname, $email, $confirm, "reset_password");
					header("Location: ../index.php");
				}
				catch(PDOException $e) {
					echo "Forget Error: " . $e->getMessage() . "<br>";
				}
			} else {
				echo ("email address not found");
			}		
		} else {
			echo "email seams to be emptyreset_email";
		}
	}

	/********************/
	/*		updte		*/
	/********************/
	if ( ($_POST['update_email']) || ($_POST['update_lName']) || ($_POST['update_fName']) || ($_POST['update_uName']) )
	{
		if(isset($_SESSION['id']))
		{
			if ($_POST['update_uName']) {
				$uName = $_POST['update_uName'];
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_fName']) {
				$fName = $_POST['update_fName'];
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_lName']) {
				$lName = $_POST['update_lName'];
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_email']) {
				$email = $_POST['update_email'];
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			(condition) ? a : b ;
			$email = $_POST['email'];
			$paswd = $_POST['password'];
			$stmt = $conn->prepare("UPDATE users SET (email, paswd) VALUES (:email, :paswd)");
			$stmt->bindparam(':email', $email);
			$stmt->bindparam(':paswd', $paswd);
			if ($stmt->execute()) {
				send_mail($email, "user details");
				echo "New record created successfully";
			} else {
				echo "Unable to create record";
			}
		}
	}

	/********************/
	/*		login		*/
	/********************/
	if ( ($_POST['loginEmail']) && $_POST['loginPassword'] )
	{ // Check if ita the right form and if form elemsnts exist
		if ( trim(($_POST['loginEmail']) != "") && trim(($_POST['loginPassword']) != "") )
		{ // Check if form elements aren't empty
			try
			{
				// prepare sql and bind parameters
				$stmt = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND pssword = :pssword");
				$email = $_POST['loginEmail'];
				$psword = strtoupper(hash('whirlpool' , $_POST['loginPassword']));
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pssword', $psword);
				$stmt->execute();
				echo $count = $stmt->rowCount() . "<br>";
				if ($count = $stmt->rowCount() == 1 ) 
				{
					echo $count = $stmt->rowCount() . "<br>";
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result['active'] == 0)
					{	//	check if account has been verified
						$_SESSION['message'] = "It seams your account has not been verified yet.<br>Please check your email for verification details.<br>";
						$_SESSION['type'] = 'danger';
						header("Location: ../login.php");
					}
					if ($result['active'] == 1) 
					{	//start session if account verified=TRUE and usr email && password match
						$username	= $_SESSION['uName'] = $result['username'];
						$firstname	= $_SESSION['fName'] = $result['firstname'];
						$lastname	= $_SESSION['sName'] = $result['lastname'];
						$email		= $_SESSION['email'] = $result['email'];
						$_SESSION['id'] = $result['id'];
						$_SESSION['type'] = 'success';
						$_SESSION['message'] = "logged in successfully<br>";
						send_mail($username, $firstname, $lastname, $email, $hash, "user login");
						header("Location: ../index.php");
					}
				}elseif ($count < 1) {
					$_SESSION['message'] = 'Incorrect email or password<br>';
					$_SESSION['type'] = 'danger';
					header("Location: ../login.php");
				}elseif ($count > 1) {
					$_SESSION['message'] = "multiple identity chrisis<br>Relax, a psychologist has been called<br>";
					$_SESSION['type'] = 'danger';
					header("Location: ../login.php");
				}else{
					$_SESSION['message'] = "We ran out of errors... who knew, we sent an admin to fix it.<br>";
					$_SESSION['type'] = 'danger';
					header("Location: ../login.php");
				}
			}
			catch(PDOException $e) {
				echo "Login error: " . $e->getMessage() . "<br>";
			}
		}
	}

	/********************/
	/*		reg			*/
	/********************/
	if ( $_POST['reg_uName'] && $_POST['reg_fName'] && $_POST['reg_sName'] && $_POST['reg_email'] && $_POST['reg_password1'] && $_POST['reg_password2'] )
	{ // Check if ita the right form and if form elemsnts exist
		if ( (trim($_POST['reg_uName']) != "") && (trim($_POST['reg_fName']) != "") && (trim($_POST['reg_sName']) != "") && (trim($_POST['reg_email']) != "") && (trim($_POST['reg_password1']) != "") && (trim($_POST['reg_password2']) != "") )
		{ // Check if form elements arent empty
			if ((trim($_POST['reg_password1'])) === (trim($_POST['reg_password2'])))
			{	// checks is passowrds match 'case sensetive'
				$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
				$email = $_POST['reg_email'];
				$query->bindParam(':email', $email);
				$query->execute();
				if ($count = $query->rowCount() == 0 )
				{ // Find out if email already exists in database (IF USER EXISTS)
					try {
						// prepare sql and bind parameters
						$stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
						(username,  firstname,  lastname,  email,  pssword,  confirm,  active) 
						VALUES (:username, :firstname, :lastname, :email, :pssword, :confirm, :active)");
						$username = $_POST['reg_uName'];
						$firstname = $_POST['reg_fName'];
						$lastname = $_POST['reg_sName'];
						$email = $_POST['reg_email'];
						$psword = strtoupper(hash('whirlpool' , $_POST['reg_password1']));
						$confirm = hash(md5 ,rand());
						$active = 0;
						
						$stmt->bindParam(':username', $username);
						$stmt->bindParam(':firstname', $firstname);
						$stmt->bindParam(':lastname', $lastname);
						$stmt->bindParam(':email', $email);
						$stmt->bindParam(':pssword', $psword);
						$stmt->bindParam(':confirm', $confirm);
						$stmt->bindParam(':active', $active);
						$stmt->execute();
						// echo "New records created successfully";
						$_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
						$_SESSION['type'] = 'success';
						send_mail($username, $firstname, $lastname, $email, $confirm, "new user");
						header("Location: ../index.php");
					}
					catch(PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br>";
					}
				}else {
					$_SESSION['message'] = "User email already exists please try to login";
					$_SESSION['type'] = 'danger';
					header("Location: ../register.php");
				}
			}else{
				$_SESSION['message'] = "Passwords don't match";
				$_SESSION['type'] = 'danger';
				header("Location: ../register.php");
			}
		}
	}

	/********************/
	/*	deregister		*/
	/********************/
	if ($_POST['delete_profile'])
	{ // 
		$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
		$email = $_POST['reg_email'];
		$query->bindParam(':email', $email);
		$query->execute();
		if ($count = $query->rowCount() == 0 )
		{ // Find out if email already exists in database (IF USER EXISTS)
			try {
				// prepare sql and bind parameters
				$stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
				(username,  firstname,  lastname,  email,  pssword,  confirm,  active) 
				VALUES (:username, :firstname, :lastname, :email, :pssword, :confirm, :active)");
				$username = $_POST['reg_uName'];
				$firstname = $_POST['reg_fName'];
				$lastname = $_POST['reg_sName'];
				$email = $_POST['reg_email'];
				$psword = strtoupper(hash('whirlpool' , $_POST['reg_password1']));
				$confirm = hash(md5 ,rand());
				$active = 0;

				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':firstname', $firstname);
				$stmt->bindParam(':lastname', $lastname);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pssword', $psword);
				$stmt->bindParam(':confirm', $confirm);
				$stmt->bindParam(':active', $active);
				$stmt->execute();
				// echo "New records created successfully";
				$_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
				$_SESSION['type'] = 'success';
				send_mail($username, $firstname, $lastname, $email, $confirm, "new user");
				header("Location: ../index.php");
			}
			catch(PDOException $e) {
				echo "Error: " . $e->getMessage() . "<br>";
			}
		}else {
			$_SESSION['message'] = "User email already exists please try to login";
			$_SESSION['type'] = 'danger';
			header("Location: ../register.php");
		}
	}
	header("Location: ../index.php");
}catch (PDOException $e) {
	echo "PDO Connection failed: " . $e->getMessage() . "<br>";
}

$conn = null;
?>
