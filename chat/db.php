<?php
require_once 'config.php'; // Include database connection
session_start();

// Reusable error handling function
function handleError($conn) {
    error_log("Database error: " . $conn->error); // Log the error for debugging
    http_response_code(500); // Internal Server Error
    echo json_encode(["status" => "error", "message" => "An unexpected error occurred. Please try again later."]);
    exit; // Stop further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create_account') {
        // Handle account creation
        $user_name = $conn->real_escape_string($_POST['user_name']);
        $user_password = $conn->real_escape_string($_POST['user_password']);

        $sql = "INSERT INTO login (user_name, user_password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_name, $user_password);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Account created successfully"]);
        } else {
            handleError($conn); // Use reusable error handler
        }
    } elseif ($action === 'delete_account') {
        // Handle account deletion
        $user_name = $_SESSION['user_name'];

        $sql = "DELETE FROM login WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_name);
        if ($stmt->execute()) {
            session_destroy(); // End the session
            echo json_encode(["status" => "success", "message" => "Account deleted successfully"]);
        } else {
            handleError($conn); // Use reusable error handler
        }
    } elseif ($action === 'login') {
        // Handle login
        $user_name = $conn->real_escape_string($_POST['user_name']);
        $user_password = $conn->real_escape_string($_POST['user_password']);

        $sql = "SELECT * FROM login WHERE user_name = ? AND user_password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_name, $user_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user_name'] = $user_name; // Track logged-in user
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
        }
    } elseif ($action === 'send_message') {
        // Handle message submission
        $sender_name = $_SESSION['user_name'];
        $receiver_name = $conn->real_escape_string($_POST['receiver_name']);
        $user_text = $conn->real_escape_string($_POST['user_text']);
        $user_img = !empty($_POST['user_img']) ? $conn->real_escape_string($_POST['user_img']) : '';

        $sql = "INSERT INTO userchat (user_name, receiver_name, user_text, user_img) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $sender_name, $receiver_name, $user_text, $user_img);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
        } else {
            handleError($conn); // Use reusable error handler
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'get_users') {
        // Fetch users
        $sql = "SELECT user_name FROM login";
        $result = $conn->query($sql);

        if (!$result) {
            handleError($conn); // Use reusable error handler
        }

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row['user_name'];
        }
        echo json_encode($users);
    } elseif ($_GET['action'] === 'get_messages') {
        // Fetch chat messages
        $sender_name = $_SESSION['user_name'];
        $receiver_name = $conn->real_escape_string($_GET['receiver_name']);

        $sql = "SELECT * FROM userchat WHERE (user_name = ? AND receiver_name = ?) OR (user_name = ? AND receiver_name = ?) ORDER BY id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $sender_name, $receiver_name, $receiver_name, $sender_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            handleError($conn); // Use reusable error handler
        }

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode($messages);
    }
}

$conn->close();
?>