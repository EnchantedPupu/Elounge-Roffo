<?php
include_once "../../utils.php";

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Room ID is required']);
    exit();
}

$room_id = $_GET['id'];
$db = create_new_database_connection();

$query = "SELECT * FROM rooms WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    echo json_encode($room);
} else {
    echo json_encode(['error' => 'Room not found']);
}

$stmt->close();
$db->close();
?>
