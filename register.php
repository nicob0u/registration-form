<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_database";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$phoneNumber = $_POST['phone_number'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$dateOfBirth = $_POST['date_of_birth'];


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password, first_name, last_name, phone_number, address, gender, date_of_birth) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "sssssssss",
  $username,
  $email,
  $hashedPassword,
  $firstName,
  $lastName,
  $phoneNumber,
  $address,
  $gender,
  $dateOfBirth
);

if ($stmt->execute()) {
  $newUserId = $stmt->insert_id;

  header("Location: print-user-info.php?id=" . $newUserId);
  exit;
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>