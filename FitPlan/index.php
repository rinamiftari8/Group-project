<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "fitplan_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($name !== "" && $password !== "") {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $email = $name;

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if (!$stmt) { die("Prepare failed: " . $conn->error); }

        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Sign Up Successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Please fill in both fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up Page</title>
<style>
body { font-family: Arial; background: #f7f7f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
.login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; text-align: center; }
input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc; }
input[type="submit"] { width: 100%; padding: 10px; background: #9B9492; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
input[type="submit"]:hover { background: #8A8280; }
.message { color: green; margin-bottom: 15px; }
.error { color: red; margin-bottom: 15px; }
</style>
</head>
<body>

<div class="login-container">
<h2>Sign Up</h2>

<?php if ($message != ""): ?>
    <div class="<?php echo strpos($message,'Error')===0?'error':'message'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <label>Username or Email</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <input type="submit" value="Sign Up">
</form>
</div>

</body>
</html>

