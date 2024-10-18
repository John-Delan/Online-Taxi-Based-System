<?php
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;

    public function __construct() {
        // Establish connection to the database
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        // Check for connection errors
        if ($this->conn->connect_error) {
            echo 'Cannot connect to database server: ' . $this->conn->connect_error;
            exit;
        }
    }

    public function __destruct() {
        // Ensure the connection is still active before closing it
        if (isset($this->conn) && $this->conn instanceof mysqli) {
            // Check if the connection has not been closed already
            if ($this->conn->ping()) {
                $this->conn->close();
            }
        }
    }
}
?>
