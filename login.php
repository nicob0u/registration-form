<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($email && $password) {
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: dashboard.php");
        exit();
      } else {
        echo "Wrong password";
      }
    } else {
      echo "User not found.";
    }
  } else {
    echo "Please enter email and password.";
  }
}
?>