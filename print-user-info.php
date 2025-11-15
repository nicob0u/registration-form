<?php
$userId = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "user_database");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Select all relevant fields
$sql = "SELECT id, first_name, last_name, username, email, phone_number, address, gender, date_of_birth 
        FROM users WHERE id = ?";
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
  <title>User Info Sheet</title>
  <style>
    body {
      margin: 0;
      font-family: 'Times New Roman', serif;
      display: flex;
      justify-content: center;
      background-color: #f0f0f0;
      /* light background to center A4 sheet */
    }

    .info-container {
      width: 210mm;
      height: 297mm;
      padding: 20mm;
      background: #fff;
      border: 1px solid #000;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      gap: 12px;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      text-transform: uppercase;
      font-size: 24px;
      letter-spacing: 1px;
    }


    .name-pair p,
    .field-row p {
      margin: 0;
      flex: 1;
      padding: 5px 10px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .name-pair,
    .field-row {
      display: flex;
      justify-content: space-between;
      gap: 20px;
    }


    button {
      margin-top: 30px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      width: 120px;
      align-self: center;
      border-radius: 5px;
      background-color: #0078d7;
      color: white;
      border: none;
    }

    button:hover {
      background-color: #005ea6;
    }

    @page {
      size: A4;
      margin: 0;
    }

    @media print {
      body {
        margin: 0;
        border: none;
        background: #fff;
      }

      .info-container {
        width: 210mm;
        height: 297mm;
        padding: 20mm;
        border: 1px solid black;
      }

      button {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="info-container">
    <h1>User Information</h1>

    <div class="name-pair">
      <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
      <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
    </div>

    <div class="field-row">
      <p><strong>User ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
      <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['date_of_birth']) ?></p>

    </div>

    <div class="field-row">
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <div class="field-row">
      <p><strong>Phone Number:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
    </div>

    <div class="field-row">
      <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
      <p></p>

    </div>



    <button onclick="window.print()">Print</button>
  </div>

</body>

</html>