<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$users = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($users as $user) {
		$user_data = explode(",", $user);
		if ($user_data[1] == $username && $user_data[2] == $password) {
			$_SESSION["username"] = $username;
			exit();
		}
	}
	$error_message = "Invalid username or password.";
}
if (isset($_SESSION["username"])) {
	$username = $_SESSION["username"];
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Welcome Page</title>
	</head>
	<body>
		<div class="container mt-4">
			<h2>Welcome <?php echo $username; ?>!</h2>
			<p>You have successfully logged in.</p>
		</div>
	</body>
	</html>
<?php
} else {
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Login Page</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container mt-4">
			<h2>Login</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="form-control" required>
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
			<?php if (isset($error_message)) : ?>
				<div class="alert alert-danger mt-4"><?php echo $error_message; ?></div>
			<?php endif; ?>
		</div>
	</body>
	</html>
<?php
}
?>