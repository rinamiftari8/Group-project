<?php
$conn = new mysqli("localhost", "root", "", "fitplan_db");

if ($conn->connect_error) {
  die("Connection failed");
}

$name = $_POST['name'];
$email = $_POST['email'];

$sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
$conn->query($sql);

echo "success";
?>

