<!DOCTYPE html>
<html>

<head>
    <title>User Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>User Registration Form</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $room_no = $_POST['room_no'];
            $ext = $_POST['ext'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_email = "Invalid email address";
            }

            if ($password != $confirm_password) {
                $error_password = "Passwords do not match";
            }

            if (isset($_FILES['profile_photo'])) {
                $file = $_FILES['profile_photo'];
                $file_type = $file['type'];
                if ($file_type != 'image/jpeg' && $file_type != 'image/png' && $file_type != 'image/gif') {
                    $error_photo = "Invalid file type. Please upload a JPEG, PNG or GIF image.";
                }
            }

            if (empty($error_email) && empty($error_password) && empty($error_photo)) {
                echo "<div class='alert alert-success'>Data saved successfully.</div>";
            }
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                <?php if (!empty($error_email)) {
                    echo "<div class='text-danger'>$error_email</div>";
                } ?>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                <?php if (!empty($error_password)) {
                    echo "<div class='text-danger'>$error_password</div>";
                } ?>
            </div>
            <div class="form-group">
                <label for="room_no">Room No:</label>
                <select class="form-control" name="room_no" id="room_no" required>
                    <option value="">Select Room No</option>
                    <option value="Application1">Application1</option>
                    <option value="Application2">Application2</option>
                    <option value="Cloud">Cloud</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ext">Ext:</label>
                <input type="text" class="form-control" name="ext" id="ext" placeholder="Enter your extension number" required>
            </div>
            <div class="form-group">
                <label for="profile_photo">Profile Picture:</label>
                <input type="file" class="form-control-file" name="profile_photo" id="profile_photo" required>
                <?php if (!empty($error_photo)) {
                    echo "<div class='text-danger'>$error_photo</div>";
                } ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "test";
$conn = mysqli_connect(
    $db_host,
    $db_user,
    $db_pass,
    $db_name
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room_no = $_POST['room_no'];
    $ext = $_POST['ext'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Invalid email address";
    }

    if ($password != $confirm_password) {
        $error_password = "Passwords do not match";
    }

    if (isset($_FILES['profile_photo'])) {
        $file = $_FILES['profile_photo'];
        $file_type = $file['type'];
        if ($file_type != 'image/jpeg' && $file_type != 'image/png' && $file_type != 'image/gif') {
            $error_photo = "Invalid file type. Please upload a JPEG, PNG or GIF image.";
        }
    }

    if (empty($error_email) && empty($error_password) && empty($error_photo)) {
        // Insert data into database
        $sql = "INSERT INTO users (name, email, password, room_no, ext, profile_photo) VALUES ('$name', '$email', '$password', '$room_no', '$ext', '$name')";
        if (mysqli_query($conn, $sql)) {
            // echo "<div class='alert alert-success'>Data saved successfully.</div>";
            header("Location: users.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
