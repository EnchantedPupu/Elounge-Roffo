<?php
class Booking{
    private $table_name = "bookings";
    private $conn;
    private $user_id, $fullname, $student_id, $room_type, $book_date, $durationhour, $purpose, $total_person, $extra, $booking_time, $approval;

    public function __construct($db, $user_id, $fullname, $student_id, $room_type, $book_date, $durationhour, $purpose, $total_person, $extra, $booking_time, $approval) {
        $this->conn = $db;
        $this->user_id = $user_id;
        $this->fullname = $fullname;
        $this->student_id = $student_id;
        $this->room_type = $room_type;
        $this->book_date = $book_date;
        $this->durationhour = $durationhour;
        $this->purpose = $purpose;
        $this->total_person = $total_person;
        $this->extra = $extra;
        $this->booking_time = $booking_time;
        $this->approval = $approval;
    }

    public function newBooking() {
        $sql = "INSERT INTO " . $this->table_name . " (user_id, fullname, student_id, room_type, book_date, durationhour, purpose, total_person, extra, booking_time, approval) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isissisisss", $this->user_id, $this->fullname, $this->student_id, $this->room_type, $this->book_date, $this->durationhour, $this->purpose, $this->total_person, $this->extra, $this->booking_time, $this->approval);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>