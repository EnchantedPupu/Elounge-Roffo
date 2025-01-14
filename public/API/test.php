<?php
include_once "../../utils.php";
include_once "booking.php";

session_start();
$email = $_SESSION['email'] ?? 'nielsivant85@gmail.com'; // Replace with actual session email
$user_id = getUserIdByEmail($email); // Function to get user_id by email

$fullname = "John Doe";
$student_id = "123";
$room_type = "Unisex";
$book_date = "2024-11-11";
$durationhour = 3;
$purpose = "testing";
$total_person = 3;
$extra = "nothing much to be seen";
$booking_time = "22:00";
$approval = "PENDING";

$db = create_new_database_connection();
$booking = new Booking($db, $user_id, $fullname, $student_id, $room_type, $book_date, $durationhour, $purpose, $total_person, $extra, $booking_time, $approval);

if ($booking->newBooking()) {
    echo var_dump($booking->newBooking());
} else {
    echo "Booking failed!";
}

function getUserIdByEmail($email) {
    // Implement this function to get user_id by email from the database
    // Example:
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