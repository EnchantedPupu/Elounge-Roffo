<?php
include_once "../../utils.php";
include_once "../API/user.php";

session_start();
$email = $_SESSION['email'];
$user_id = getUserIdByEmail($email);

$db = create_new_database_connection();
$query = "SELECT id as id, book_date as date, booking_time as time, room_type as room, durationhour as duration, purpose, approval as status FROM bookings WHERE user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$stmt->close();
$db->close();

echo json_encode($bookings);

function getUserIdByEmail($email) {
    $db = create_new_database_connection();
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    $db->close();
    return $user_id;
}
?>