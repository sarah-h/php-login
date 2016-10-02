<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: secret-page.php");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Log-in</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet" text="text/css">
</head>
<body>

	<div class="header">
		<a href="/php-login/index.php">LOG-IN SYSTEM</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>LOG-IN</h1>
	<span>or <a href="register.php">REGISTER HERE</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter Your Email" name="email">
		<input type="password" placeholder="Enter Your Password" name="password">

		<input type="submit">

	</form>

</body>
</html>