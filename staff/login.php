<?php
// DBConnection.php class definition
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost'); // replace with your DB server
    define('DB_USERNAME', 'root'); // replace with your DB username
    define('DB_PASSWORD', ''); // replace with your DB password
    define('DB_NAME', 'cbsphp'); // replace with your DB name
}

class DBConnection {
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            echo 'Cannot connect to database server: ' . $this->conn->connect_error;
            exit;
        }
    }
}

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Create DB connection
        $db = new DBConnection();
        $conn = $db->conn;

        // Prepare and execute the statement
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM staff WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $firstname, $lastname, $stored_password);
            $stmt->fetch();

            // Verify the password directly
            if ($password === $stored_password) { // Compare plaintext passwords
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $firstname . ' ' . $lastname;

                // Update last login time
                $update_stmt = $conn->prepare("UPDATE staff SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $id);
                $update_stmt->execute();

                // Redirect to dashboard
                header("Location: form.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
        $conn->close();  // Explicitly close the connection when done
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="SS.css">
</head>
<body>
    <div class="login-container">
        <h2>Staff Login</h2>
        <?php if (isset($error)) : ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
