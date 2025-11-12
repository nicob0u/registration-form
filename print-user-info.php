<?php
$userId = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "user_database");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Page</title>
  <style>
    body {
      width: 210mm;
      height: 297mm;
      margin: 20mm auto;
      font-family: 'Times New Roman', serif;
      border: 1px solid black;
    }

    .info-container {
      page-break-inside: avoid;
      padding: 6mm;
    }


    @media print {
      button {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="info-container" id="infoContainer">
    <p><strong>Username:</strong>
      <?=
        htmlspecialchars($user['username']) ?>
    </p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>User ID:</strong>
      <?=
        htmlspecialchars($user['id']) ?>
    </p>
    <button onclick="window.print()">Print</button>
  </div>



</body>

</html>