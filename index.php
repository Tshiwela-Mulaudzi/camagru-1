<?php 
session_start();
$page_title = "Camagru Home";
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
		<?php 
		if ($sess) 
			echo '<li role="presentation"><a href="forms/logout.php">Logout</a></li>';
		else
			echo '<li role="presentation"><a href="login.php">Login</a></li>';
		?>
	</ul>
</section>

<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<h2>MaiN</h2>
	<?php
	echo ("<div class=".$type.">".$message."</div>");
		// $_SESSION['type'] = "";			// for Errors if any
		// $_SESSION['message'] = "";		// for Errors if any

		// $query = $conn->prepare("SELECT * FROM $username ORDER BY timestmp DESC LIMIT 10");	
		// $result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		// try{
		// 	$stmt = $conn->prepare("SELECT * FROM $username ORDER BY timestmp DESC LIMIT 10"); 
		// 	$stmt->execute();

		// 	// set the resulting array to associative
		// 	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		// 	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
		// 		echo $v;
		// 	}
		// }
		// catch(PDOException $e) {
		// 	echo "Error: " . $e->getMessage();
		// }
	?>
	<?php		echo('id: '.$_SESSION['id']) .'<br>';
	echo('uName: '.$_SESSION['uName']) .'<br>';
	echo('fName: '.$_SESSION['fName']) .'<br>';
	echo('sName: '.$_SESSION['sName']) .'<br>';
	echo('email: '.$_SESSION['email']) .'<br>';
	?>
	
	<div>
			SELECT * FROM TABLE
	</div>
</section>

<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>