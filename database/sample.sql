use elounge;

insert into users (name, email, password, isadmin, sex, profile_pic) values
('John Doe', 'nobody@example.com', '123456', 0, 'male', 'default.jpg'),
('Jane Doe', 'jane@example.com', '123456', 0, 'female', 'default.jpg'),
('Admin', 'admin@ex.com', '123456', 1, 'male', 'default.jpg');

insert into rooms (name, block, unit, type, status, max_persons) values
('Room 1', 'Block A', 'Unit 1', 'Single', 'Available', 1),
('Room 2', 'Block B', 'Unit 2', 'Single', 'Available', 1),
('Room 3', 'Block C', 'Unit 3', 'Single', 'Available', 1),
('Room 4', 'Block D', 'Unit 4', 'Single', 'Available', 1),
('Room 5', 'Block E', 'Unit 5', 'Single', 'Available', 1),
('Room 6', 'Block F', 'Unit 6', 'Single', 'Available', 1),
('Room 7', 'Block G', 'Unit 7', 'Single', 'Available', 1),
('Room 8', 'Block H', 'Unit 8', 'Single', 'Available', 1),
('Room 9', 'Block I', 'Unit 9', 'Single', 'Available', 1),
('Room 10', 'Block J', 'Unit 10', 'Single', 'Available', 1);

insert into bookings (user_id, room_id, date, approval, check_in, check_out, total_person) values
(1, 1, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(2, 2, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(1, 3, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(2, 4, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(1, 5, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(2, 6, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(1, 7, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(2, 8, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(1, 9, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1),
(2, 10, '2021-01-01', 'Approved', '2021-01-01', '2021-01-02', 1);

insert into transactions (booking_id, amount, transactions_type, status) values
(1, 100, 'Booking', 'Success'),
(2, 100, 'Booking', 'Success'),
(3, 100, 'Booking', 'Success'),
(4, 100, 'Booking', 'Success'),
(5, 100, 'Booking', 'Success'),
(6, 100, 'Booking', 'Success'),
(7, 100, 'Booking', 'Success'),
(8, 100, 'Booking', 'Success'),
(9, 100, 'Booking', 'Success'),
(10, 100, 'Booking', 'Success');



