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

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    // 5. Return user info (without password)
    echo json_encode([
        "id" => $stmt->insert_id,
        "username" => $username,
        "email" => $email
    ]);
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>