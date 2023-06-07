<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
</head>
<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "test";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "<form class='container p-5' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
    echo "<div class='mb-3'><label class='form-label'>Name:</label> <input class='form-control' type='text' name='name' value='" . $row['name'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Email:</label> <input class='form-control' type='text' name='email' value='" . $row['email'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Password:</label> <input class='form-control' type='password' name='password' value='" . $row['password'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Confirm Password:</label> <input class='form-control' type='password' name='confirm_password' value='" . $row['password'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Room No:</label> <input class='form-control' type='text' name='room_no' value='" . $row['room_no'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Ext:</label> <input class='form-control' type='text' name='ext' value='" . $row['ext'] . "'></div>";
    echo "<div class='mb-3'><label class='form-label'>Profile Photo:</label> <input class='form-control' type='file' name='profile_photo'></div>";
    echo "<img src='uploads/" . $row['profile_photo'] . "'><br>";
    echo "<input class='btn btn-primary' href='users.php' type='submit' name='update' value='Update'>";
    echo "</form>";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='container alert alert-success'>User deleted successfully.</div>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
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
        $sql = "UPDATE users SET name='$name', email='$email', password='$password', room_no='$room_no', ext='$ext', profile_photo='$name' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='container alert alert-success'>User updated successfully.</div>";
            header("Location: users.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
echo "<div class='container mt-5'>";
echo "<table class='table'>";
echo "<thead><tr><th>Name</th><th>Email</th><th>Room No</th><th>Ext</th><th>Profile Photo</th><th>Action</th></tr></thead>";
echo "<tbody>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['room_no'] . "</td>";
    echo "<td>" . $row['ext'] . "</td>";
    echo "<td><img src='uploads/" . $row['profile_photo'] . "' width='100'></td>";
    echo "<td><a class='btn btn-primary' href='users.php?edit=" . $row['id'] . "'>Edit</a>";
    echo " <a class='btn btn-danger' href='users.php?delete=" . $row['id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";

mysqli_close($conn);
?>
