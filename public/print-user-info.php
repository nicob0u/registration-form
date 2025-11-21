<?php
$userId = $_GET['id'] ?? 0;
$conn = new mysqli("localhost", "root", "", "user_database");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, first_name, last_name, username, email, phone_number, address, gender, date_of_birth 
        FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Info Form</title>
  <style>
    body {
      font-family: 'Times New Roman', serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      background-color: #f0f0f0;
    }

    .form-container {
      width: 210mm;
      min-height: 297mm;
      background: #fff;
      padding: 20mm;
      box-sizing: border-box;
      border: 1px solid #000;
      display: flex;
      flex-direction: column;
    }

    header {
      text-align: center;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    header h1 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .info-table td {
      padding: 8px 12px;
      border: 1px solid #000;
      font-size: 16px;
    }

    .info-table td.label {
      font-weight: bold;
      background-color: #f2f2f2;
      width: 35%;
    }

    .description-section {
      border: 1px solid #000;
      height: 250px;
      padding: 10px;
      margin-top: 20px;
    }

    .description-section::before {
      content: "Description / Notes:";
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
    }

    button.print-btn {
      margin-top: auto;
      align-self: center;
      padding: 10px 25px;
      font-size: 16px;
      border-radius: 5px;
      background-color: #0078d7;
      color: #fff;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: left;
    }

    button.print-btn:hover {
      background-color: #005ea6;
    }

    button.print-btn img {
      margin-right: 10px;

    }

    @media print {
      * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      body {
        background: #fff;
      }

      .form-container {
        border: none;
        box-shadow: none;
        width: 100%;
        height: auto;
        padding: 20mm;
      }

      button.print-btn {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="form-container">
    <header>
      <h1>User Information Form</h1>
    </header>

    <table class="info-table">
      <tr>
        <td class="label">First Name</td>
        <td><?= htmlspecialchars($user['first_name']) ?></td>
        <td class="label">Last Name</td>
        <td><?= htmlspecialchars($user['last_name']) ?></td>
      </tr>
      <tr>
        <td class="label">User ID</td>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td class="label">Date of Birth</td>
        <td><?= htmlspecialchars($user['date_of_birth']) ?></td>
      </tr>
      <tr>
        <td class="label">Username</td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td class="label">Email</td>
        <td><?= htmlspecialchars($user['email']) ?></td>
      </tr>
      <tr>
        <td class="label">Phone Number</td>
        <td><?= htmlspecialchars($user['phone_number']) ?></td>
        <td class="label">Gender</td>
        <td><?= htmlspecialchars($user['gender']) ?></td>
      </tr>
      <tr>
        <td class="label">Address</td>
        <td colspan="3"><?= htmlspecialchars($user['address']) ?></td>
      </tr>
    </table>

    <div class="description-section">
    </div>

    <button class="print-btn" onclick="window.print()"><img src="icons/print2.png">Print</button>
  </div>
</body>

</html>