<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	// Enter the new user in the database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register An Account</title>
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

	<h1>REGISTER YOUR ACCOUNT</h1>
	<span>or <a href="login.php">LOG-IN</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="Enter Your Email" name="email">
		<input type="password" placeholder="Password" name="password">
		<input type="password" placeholder="Confirm Password" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>