<?php
include_once "../API/user.php";
include_once "../../utils.php";
include_once "../API/booking.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $user_id = getUserIdByEmail($_SESSION['email']); // Function to get user_id by email

    // Get the raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    $fullname = $data['fullname'];
    $student_id = $data['studentId'];
    $room_type = $data['roomType'];
    $book_date = $data['date'];
    $durationhour = $data['durationhour'];
    $purpose = $data['purpose'];
    $total_person = $data['numPeople'];
    $extra = $data['extra'];
    $booking_time = $data['time'];
    $approval = "PENDING";

    $db = create_new_database_connection();
    $booking = new Booking($db, $user_id, $fullname, $student_id, $room_type, $book_date, $durationhour, $purpose, $total_person, $extra, $booking_time, $approval);
    
    if ($booking->newBooking()) {
        //echo json_encode(array("message" => "Booking successful!", "user_id" => $user_id, "fullname" => $fullname, "student_id" => $student_id, "room_type" => $room_type, "book_date" => $book_date, "durationhour" => $durationhour, "purpose" => $purpose, "total_person" => $total_person, "extra" => $extra, "booking_time" => $booking_time, "approval" => $approval));
        echo json_encode(array("message" => "Booking successful!"));
    } else {
        echo json_encode(array("message" => "Booking failed!"));
    }
}

function getUserIdByEmail($email)
{
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