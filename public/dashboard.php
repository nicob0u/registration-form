<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION["user_id"])) {
  header("Location: login.html");
  exit();
}

$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalRow = $totalQuery->fetch_assoc();
$totalUsers = $totalRow['total'];

$newestQuery = $conn->query("SELECT username FROM users ORDER BY id DESC LIMIT 1");
$newestRow = $newestQuery->fetch_assoc();
$newestUser = $newestRow['username'];

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

  <div class="layout">

    <aside class="sidebar">
      <h2 class="logo">Dashboard</h2>

      <nav>
        <a href="dashboard.php" class="active"><img src="icons/house-chimney-heart.svg" class="icon" alt="Home">Home</a>
        <a href="#"><img src="icons/settings-sliders.svg" class="icon" alt="Settings">Account Settings</a>
        <!-- <a href="#">Profile</a> -->
        <a href="logout.php"><img src="icons/user-logout.svg" class="icon" alt="Logout">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
      <div class="notification-wrapper">
        <img src="icons/notif.svg" alt="Notifications" class="notification-icon" id="notifIcon">

        <div class="notification-box" id="notifBox">
          <ul>
            <li>Your current password is very weak. Please consider changing it as soon as possible.</li>
            <li>Your profile picture was updated.</li>
            <li>Welcome!</li>
          </ul>
        </div>
      </div>

      <div class="cards">
        <div class="card">Total users: <?php echo $totalUsers; ?></div>
        <div class="card">Your Last Login: today</div>
        <div class="card">Newest user: <?php echo htmlspecialchars($newestUser); ?></div>

      </div>
      <div class="footer">
        <a href="print-user-info.php?id=<?php echo $_SESSION['user_id']; ?>" class="print-button">
          <img src="icons/print.svg" class="print-icon" alt="Print">
          Print User Info
        </a>
      </div>

    </main>

  </div>


  <script>
    const notifIcon = document.getElementById('notifIcon');
    const notifBox = document.getElementById('notifBox');

    notifIcon.addEventListener('click', () => {
      notifBox.style.display = notifBox.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!notifBox.contains(e.target) && e.target !== notifIcon) {
        notifBox.style.display = 'none';
      }
    });
  </script>

</body>

</html>