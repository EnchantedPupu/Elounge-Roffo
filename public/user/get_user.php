<?php
session_start();
include_once "../../utils.php";

// Check if user is admin
if ($_SESSION['user'] != "admin") {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

$conn = create_new_database_connection();
$userId = intval($_GET['id']);

// Prepare and execute query
$stmt = $conn->prepare("SELECT id, name, email, faculty, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'User not found']);
    exit();
}

// Get user data and return as JSON
$userData = $result->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($userData);

$stmt->close();
$conn->close();
?>