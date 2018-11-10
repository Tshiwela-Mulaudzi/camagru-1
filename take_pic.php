<?php 
session_start();
$page_title = "Take selfie";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	include 'frame/head.php';
} else {
	header("Location: login.php");
}
?>

	<section class="shadow-lg p-3 mb-5 bg-white " id="header">
		<ul class="nav nav-pills">
			<li role="presentation" class="active"><a href="index.php">Comagaru</a></li>
			<li role="presentation"><a href="profile.php">Profile</a></li>
		</ul>
	</section>
	
	<section class="shadow-lg p-3 mb-5 bg-white " id="main">
		<h2>Take pic</h2>
		<div class="top-container">
				<div id="overlay-options">
					<input type="radio" name="overlay" value="#" id="none" checked="checked"> Default
					<input type="radio" name="overlay" value="res/mask1.png" id="crazy"> crazy
					<input type="radio" name="overlay" value="res/mask2.png" id="catface"> catface
					<input type="radio" name="overlay" value="." id="anonimus"> anonimus
					<input type="radio" name="overlay" value="." id="cuagmire"> Cuagmire
					<input type="radio" name="overlay" value="." id="sponge"> Sponge
					<input type="radio" name="overlay" value="." id="classic"> Classic
				</div>
				<!-- <div id="overlay-options">
					<input type="radio" name="overlay" value="#" id="none" checked="checked"> None
					<input type="radio" name="overlay" value="https://dumielauxepices.net/sites/default/files/catwoman-clipart-face-883550-3607898.png" id="crazy"> crazy
					<input type="radio" name="overlay" value="http://shopforclipart.com/images/funny-face-clipart/20.jpg" id="catface"> catface
					<input type="radio" name="overlay" value="http://www.transparentpng.com/thumb/anonymous-mask/face-mask-funny-fear-nickname-face-anonymous-mask-png-images--15.png" id="anonimus"> anonimus
					<input type="radio" name="overlay" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbZ-iwDmJ742m1J2SudaOQJ7qbCLdEruSfTQYoZOPVf6yR8y_Z4Q" id="cuagmire"> Cuagmire
					<input type="radio" name="overlay" value="https://png.pngtree.com/element_pic/16/12/01/5b3008293536496b29c22ef56c3c9e92.jpg" id="sponge"> Sponge
					<input type="radio" name="overlay" value="https://www.clipartmax.com/png/middle/18-187369_face-glasses-clipart-funny-face-icon-png.png" id="classic"> Classic
				</div> -->
			<div id="vid_div">
				<div>
					<button id="photo-button" class="btn btn-dark">Take Photo</button>
					<button id="clear-button">Clear</button>
				</div>
				<img id="tmpImg" src="#"  alt="">
				<video id="video">Stream broken...</video>
			</div>
			<div id="photos"></div>
		</div>
		<canvas id="canvas"></canvas>
	</section>
	
	<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
		<h2>footer</h2>
	</section>
	<script src="./style/take_pic.js"></script>
</body>
</html>