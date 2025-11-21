<?php
session_start();
require '../includes/db.php';
$error = '';

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
        $error = "Wrong password";
      }
    } else {
      $error = "User not found";

    }
  } else {
    $error = "Please enter email and password.";
  }
}


?>


<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <title>Login</title>
</head>

<body>
  <div class="container">
    <h1>LOGIN</h1>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>


    <form action="login.php" method="POST">
      <div class="input-group">
        <label for="email">EMAIL</label>
        <input type="email" id="email" placeholder="your@email.com" name="email">
      </div>

      <div class="input-group">
        <label for="password">PASSWORD</label>
        <input type="password" id="password" placeholder="••••••••" name="password">
      </div>

      <button type="submit" class="login-button"> <img src="icons/login.svg" alt="Login" class="icon"
          style="scale: -1; height: 18px; margin-right: 15px;">
        LOG IN</button>

    </form>
    <div class="divider">OR</div>

    <div class="social-login">
      <div class="social-btn"><img src="icons/google.svg" alt="Google" class="icon"></div>
      <div class="social-btn"><img src="icons/facebook.svg" alt="Facebook" class="icon"></div>
      <div class="social-btn"><img src="icons/x.svg" alt="X" class="icon"></div>
    </div>

    <div class="footer">
      Don't have an account? <a href="register.html">Sign up</a>
    </div>
  </div>
</body>

</html>