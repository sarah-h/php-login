<?php

session_start();

require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome.</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet" text="text/css">
</head>
<body>

	<div class="header">
		<a href="/php-login/index.php">LOG-IN SYSTEM</a>
	</div>

	<?php if( !empty($user) ): ?>

		<br />WELCOME, <?= $user['email']; ?> 
		<br /><br />YOU ARE SUCCESSFULLY LOGGED-IN.
		<br /><br />
        <a href="secret-page.php">ENTER THE SECRET PAGE</a>
        <br /><br />
		<a href="logout.php">LOG OUT</a>

	<?php else: ?>

		<h1>WELCOME!</h1>
        <h2>Please log-in or register an account below.</h2>
		<a href="login.php">LOG-IN</a> or
		<a href="register.php">REGISTER</a>

	<?php endif; ?>

</body>
</html>