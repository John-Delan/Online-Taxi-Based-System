<?php
require_once '../config.php'; // Include your database connection file

// Function to check if a username already exists
function username_exists($conn, $username, $id = null) {
    if ($id) {
        // Check for username existence, ignoring the current user's ID
        $stmt = $conn->prepare("SELECT COUNT(*) FROM staff WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $id);
    } else {
        // Check if the username exists without an ID
        $stmt = $conn->prepare("SELECT COUNT(*) FROM staff WHERE username = ?");
        $stmt->bind_param("s", $username);
    }
    
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    return $count > 0; // Returns true if username exists
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $last_login = isset($_POST['last_login']) ? $_POST['last_login'] : null;

    // Check if username already exists
    if (username_exists($conn, $username, $id)) {
        echo "Username already exists"; // Respond with an error message
        exit;
    }

    // Hash the password if it's provided
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // If password is empty, retrieve the existing one if updating
        $existing_user = $conn->query("SELECT password FROM staff WHERE id = '$id'");
        $existing_data = $existing_user->fetch_assoc();
        $password = $existing_data['password'];
    }

    // Check if it's an update or a new entry
    if ($id) {
        // Update existing staff
        $stmt = $conn->prepare("UPDATE staff SET firstname=?, lastname=?, username=?, password=?, last_login=? WHERE id=?");
        $stmt->bind_param("sssssi", $firstname, $lastname, $username, $password, $last_login, $id);
    } else {
        // Insert new staff
        $stmt = $conn->prepare("INSERT INTO staff (firstname, lastname, username, password, last_login) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $last_login);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo 1; // Success
    } else {
        echo 0; // Failure
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Additional logic for handling other request methods (GET, DELETE, etc.) can go here if needed.
