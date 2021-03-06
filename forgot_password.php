<?php 
session_start();
$page_title = "Camagru lost passwords";
include 'frame/head.php';
?>

<!-- header startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="header">
	<ul class="nav nav-pills">
		<li role="presentation" class="active"><a href="index.php">Comagaru</a></li>
		<li role="presentation"><a href="profile.php">Profile</a></li>
		<?php 
		if ($sess) 
			echo '<li role="presentation"><a href="forms/logout.php">Logout</a></li>';
		else
			echo '<li role="presentation"><a href="login.php">Login</a></li>';
		?>
	</ul>
</section>

<!-- main startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<h2>Forgot Password</h2>
		<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
	<form name="reg_form" action="forms/form.php" method="POST">
		<div class="form-group">
			<label for="email">Email address</label>
			<input required type="email" class="form-control" id="reset_email" name="reset_email" placeholder="Email" >
		</div>
		<button type="submit" class="btn btn-default" name="forgot_password" value="forgot_password">Submit</button>
	</form>
	<div class="col-xs-6 tex-left"><a href="register.php">Don't have an account? Click to register</a></div>
	<div class="col-xs-6 text-right"><a href="login.php">Know your login details? Click here</a></div>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php 
// $_SESSION['type'] = '';
// $_SESSION['message'] = '';
include 'frame/tail.php'; 
?>