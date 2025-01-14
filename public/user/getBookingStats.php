<?php
include_once "../../utils.php";
include_once "../API/user.php";

session_start();
$email = $_SESSION['email'];
$user_id = getUserIdByEmail($email);

$db = create_new_database_connection();
$query = "SELECT DATE_FORMAT(STR_TO_DATE(book_date, '%Y-%m-%d'), '%M') as month, SUM(durationhour) as total_hours FROM bookings WHERE user_id = ? GROUP BY MONTH(STR_TO_DATE(book_date, '%Y-%m-%d'))";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stats = [];
while ($row = $result->fetch_assoc()) {
    $stats[] = $row;
}

$stmt->close();
$db->close();

echo json_encode($stats);

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
