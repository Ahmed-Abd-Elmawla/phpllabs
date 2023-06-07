<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<h2 class="mt-4 mb-4">Add User</h2>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
			<div class="form-group"></div>
			<label for="name">Name:</label>
			<input type="text" name="name" id="name" class="form-control" required>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control" required>
				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$email = $_POST["email"];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo "<span style='color: red;'>Invalid email format.</span>";
					}
				}
				?>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="confirm_password">Confirm Password:</label>
				<input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="room_no">Room No:</label>
				<select name="room_no" id="room_no" class="form-control" required>
					<option value="" disabled selected>Select Room No</option>
					<option value="Application1">Application1</option>
					<option value="Application2">Application2</option>
					<option value="cloud">Cloud</option>
				</select>
			</div>
			<div class="form-group">
				<label for="ext">Ext:</label>
				<input type="text" name="ext" id="ext" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="profile_photo">Profile Photo:</label>
				<input type="file" name="profile_photo" id="profile_photo" class="form-control-file" accept="image/*" required>
				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$profile_photo = $_FILES["profile_photo"]["name"];
					$profile_photo_type = $_FILES["profile_photo"]["type"];
					if ($profile_photo_type != "image/jpeg" && $profile_photo_type != "image/png") {
						echo "<span style='color: red;'>Invalid file format. Please upload a JPEG or PNG file.</span>";
					}
				}
				?>
			</div>
			<button type="submit" name="save" class="btn btn-primary">Save</button>
			<button type="reset" name="reset" class="btn btn-secondary">Reset</button>
		</form>
	</div>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$room_no = $_POST["room_no"];
	$ext = $_POST["ext"];
	$profile_photo = $_FILES["profile_photo"]["name"];
	$profile_photo_type = $_FILES["profile_photo"]["type"];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<span style='color: red;'>Invalid email format.</span>";
	} else if ($password != $confirm_password) {
		echo "<span style='color: red;'>Passwords do not match.</span>";
	} else if ($profile_photo_type != "image/jpeg" && $profile_photo_type != "image/png") {
		echo "<span style='color: red;'>Invalid file format. Please upload a JPEG or PNG file.</span>";
	} else {
		$user_data = "$name,$email,$password,$room_no,$ext,$profile_photo\n";
		file_put_contents("users.txt", $user_data, FILE_APPEND | LOCK_EX);
		echo "<div class='alert alert-success mt-4'>User data saved successfully.</div>";
	}
}
?>