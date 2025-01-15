<?php
session_start();
include_once "../../utils.php";
$conn = create_new_database_connection();

// Check if user is admin
if ($_SESSION['user'] != "admin") {
    header("Location: /public/index.php");
    exit();
}

// Additional functionality for searching and filtering
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
$filter_status = isset($_GET['booking_status']) ? $_GET['booking_status'] : '';

// Fetch unique faculties for filter
$faculties = $conn->query("SELECT DISTINCT faculty FROM users ORDER BY faculty");

// Modified queries with search and filters
$userQuery = "SELECT * FROM users WHERE 1=1";
if ($search) {
    $search = "%$search%";
    $userQuery .= " AND (name LIKE ? OR email LIKE ? OR matric LIKE ?)";
}
if ($filter_faculty) {
    $userQuery .= " AND faculty = ?";
}
$userQuery .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($userQuery);
if ($search && $filter_faculty) {
    $stmt->bind_param("ssss", $search, $search, $search, $filter_faculty);
} elseif ($search) {
    $stmt->bind_param("sss", $search, $search, $search);
} elseif ($filter_faculty) {
    $stmt->bind_param("s", $filter_faculty);
}
$stmt->execute();
$users = $stmt->get_result();

// Handle user CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_user':
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $matric = $_POST['matric'];
                $gender = $_POST['gender'];
                $faculty = $_POST['faculty'];
                $phone = $_POST['phone'];
                $residential = $_POST['residential'];
                $bio = $_POST['bio'];

                $stmt = $conn->prepare("INSERT INTO users (name, email, password, matric, gender, faculty, phone, residential, bio, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'default.jpg')");
                $stmt->bind_param("sssssssss", $name, $email, $password, $matric, $gender, $faculty, $phone, $residential, $bio);
                $stmt->execute();
                break;

            case 'update_user':
                $id = $_POST['user_id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $faculty = $_POST['faculty'];
                $phone = $_POST['phone'];

                $stmt = $conn->prepare("UPDATE users SET name=?, email=?, faculty=?, phone=? WHERE id=?");
                $stmt->bind_param("ssssi", $name, $email, $faculty, $phone, $id);
                $stmt->execute();
                break;

            case 'delete_user':
                $id = $_POST['user_id'];
                $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                break;

            case 'update_booking':
                $id = $_POST['booking_id'];
                $approval = $_POST['approval'];

                $stmt = $conn->prepare("UPDATE bookings SET approval=? WHERE id=?");
                $stmt->bind_param("si", $approval, $id);
                $stmt->execute();
                break;

            case 'create_room':
                $name = $_POST['name'];
                $block = $_POST['block'];
                $unit = $_POST['unit'];
                $type = $_POST['type'];
                $status = $_POST['status'];
                $max_persons = $_POST['max_persons'];

                $stmt = $conn->prepare("INSERT INTO rooms (name, block, unit, type, status, max_persons) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssi", $name, $block, $unit, $type, $status, $max_persons);
                $stmt->execute();
                break;

            case 'update_room':
                $id = $_POST['room_id'];
                $name = $_POST['name'];
                $block = $_POST['block'];
                $unit = $_POST['unit'];
                $type = $_POST['type'];
                $status = $_POST['status'];
                $max_persons = $_POST['max_persons'];

                $stmt = $conn->prepare("UPDATE rooms SET name=?, block=?, unit=?, type=?, status=?, max_persons=? WHERE id=?");
                $stmt->bind_param("ssssssi", $name, $block, $unit, $type, $status, $max_persons, $id);
                $stmt->execute();
                break;

            case 'delete_room':
                $id = $_POST['room_id'];
                $stmt = $conn->prepare("DELETE FROM rooms WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                break;
        }
    }
}

// Fetch analytics data
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$totalBookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$totalRooms = $conn->query("SELECT COUNT(*) as count FROM rooms")->fetch_assoc()['count'];
$monthlyBookings = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE MONTH(created_at) = MONTH(CURRENT_DATE())")->fetch_assoc()['count'];

// Fetch users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Fetch pending bookings
$pendingBookings = $conn->query("SELECT b.*, u.name as user_name FROM bookings b JOIN users u ON b.user_id = u.id WHERE b.approval = 'pending' ORDER BY b.created_at DESC");

// Fetch rooms
$rooms = $conn->query("SELECT * FROM rooms ORDER BY created_at DESC");

// Fetch all bookings
$allBookingsQuery = "SELECT b.*, u.name as user_name FROM bookings b JOIN users u ON b.user_id = u.id";
if ($filter_status) {
    $allBookingsQuery .= " WHERE b.approval = ?";
}
$allBookingsQuery .= " ORDER BY b.created_at DESC";

$allBookingsStmt = $conn->prepare($allBookingsQuery);
if ($filter_status) {
    $allBookingsStmt->bind_param("s", $filter_status);
}
$allBookingsStmt->execute();
$allBookings = $allBookingsStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            padding: 1rem 1.5rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .table th {
            background-color: #f8f9fa;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            margin: 0 0.2rem;
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dashboard-header {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 1rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="#dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#users">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#bookings">
                                <i class="bi bi-calendar-check"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#rooms">
                                <i class="bi bi-door-open"></i> Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#allBookings">
                                <i class="bi bi-list"></i> View All Bookings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1>Welcome, Admin</h1>
                            <p class="mb-0">Manage your e-lounge system efficiently</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button class="btn btn-light ms-2" onclick="location.href='logout.php'">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <div class="card mt-4" id="users">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h5 class="mb-0">Users Management</h5>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput"
                                        placeholder="Search users...">
                                    <select class="form-select" id="facultyFilter">
                                        <option value="">All Faculties</option>
                                        <?php while ($faculty = $faculties->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($faculty['faculty']); ?>">
                                                <?php echo htmlspecialchars($faculty['faculty']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="bi bi-plus-circle"></i> Add New User
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Matric</th>
                                        <th>Faculty</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = $users->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $user['id']; ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['matric']); ?></td>
                                            <td><?php echo htmlspecialchars($user['faculty']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="editUser(<?php echo $user['id']; ?>)">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pending Bookings Section -->
                <div class="card mt-4" id="bookings">
                    <div class="card-header">
                        <h5>Pending Bookings</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Room Name</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Purpose</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($booking = $pendingBookings->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $booking['id']; ?></td>
                                            <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                            <td><?php echo htmlspecialchars($booking['book_date']); ?></td>
                                            <td><?php echo $booking['durationhour']; ?> hours</td>
                                            <td><?php echo htmlspecialchars($booking['purpose']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success"
                                                    onclick="updateBooking(<?php echo $booking['id']; ?>, 'APPROVED')">Approve</button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="updateBooking(<?php echo $booking['id']; ?>, 'REJECTED')">Reject</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Rooms Section -->
                <div class="card mt-4" id="rooms">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h5 class="mb-0">Rooms Management</h5>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchRoomInput"
                                        placeholder="Search rooms...">
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                    <i class="bi bi-plus-circle"></i> Add New Room
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Block</th>
                                        <th>Unit</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Max Persons</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($room = $rooms->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $room['id']; ?></td>
                                            <td><?php echo htmlspecialchars($room['name']); ?></td>
                                            <td><?php echo htmlspecialchars($room['block']); ?></td>
                                            <td><?php echo htmlspecialchars($room['unit']); ?></td>
                                            <td><?php echo htmlspecialchars($room['type']); ?></td>
                                            <td><?php echo htmlspecialchars($room['status']); ?></td>
                                            <td><?php echo $room['max_persons']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="editRoom(<?php echo $room['id']; ?>)">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteRoom(<?php echo $room['id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- View All Bookings Section -->
                <div class="card mt-4" id="allBookings">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h5 class="mb-0">All Bookings</h5>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <select class="form-select" id="bookingStatusFilter" onchange="filterBookings()">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Room Name</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($booking = $allBookings->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $booking['id']; ?></td>
                                            <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                            <td><?php echo htmlspecialchars($booking['book_date']); ?></td>
                                            <td><?php echo $booking['durationhour']; ?> hours</td>
                                            <td><?php echo htmlspecialchars($booking['purpose']); ?></td>
                                            <td><?php echo htmlspecialchars($booking['approval']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <!-- Analytics Cards -->
                    <div class="row mt-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5>Total Users</h5>
                                    <h2><?php echo $totalUsers; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h5>Total Bookings</h5>
                                    <h2><?php echo $totalBookings; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <h5>Total Rooms</h5>
                                    <h2><?php echo $totalRooms; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">
                                    <h5>Monthly Bookings</h5>
                                    <h2><?php echo $monthlyBookings; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </main>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="POST">
                        <input type="hidden" name="action" value="create_user">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Matric Number</label>
                            <input type="text" class="form-control" name="matric" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Faculty</label>
                            <input type="text" class="form-control" name="faculty" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Residential</label>
                            <input type="text" class="form-control" name="residential" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" name="bio" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        <input type="hidden" name="action" value="update_user">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Faculty</label>
                            <input type="text" class="form-control" name="faculty" id="edit_faculty" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="edit_phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoomForm" method="POST">
                        <input type="hidden" name="action" value="create_room">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Block</label>
                            <input type="text" class="form-control" name="block" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" class="form-control" name="unit" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" name="type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" name="status" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max Persons</label>
                            <input type="number" class="form-control" name="max_persons" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm" method="POST">
                        <input type="hidden" name="action" value="update_room">
                        <input type="hidden" name="room_id" id="edit_room_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="edit_room_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Block</label>
                            <input type="text" class="form-control" name="block" id="edit_room_block" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" class="form-control" name="unit" id="edit_room_unit" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" name="type" id="edit_room_type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" name="status" id="edit_room_status" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max Persons</label>
                            <input type="number" class="form-control" name="max_persons" id="edit_room_max_persons" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize DataTables
        $(document).ready(function () {
            $('#usersTable').DataTable({
                pageLength: 10,
                ordering: true,
                responsive: true
            });
        });

        const editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('hidden.bs.modal', function () {
            // Reset form and error states when modal is closed
            document.getElementById('editUserForm').reset();
            const submitButton = document.querySelector('#editUserForm button[type="submit"]');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Update User';
        });

        document.getElementById('editUserForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';

            const formData = new FormData(this);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Reload the page to show updated data
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error updating user:', error);
                    alert('Error updating user. Please try again.');
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Update User';
                });
        });

        // Add real-time search functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const table = document.querySelector('.table tbody');
            const rows = table.getElementsByTagName('tr');

            for (let row of rows) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            }
        });

        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(userId) {
            // Show loading state
            const loadingToast = new bootstrap.Toast(document.createElement('div'));
            loadingToast.show();

            fetch(`get_user.php?id=${userId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the modal fields
                    document.getElementById('edit_user_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_faculty').value = data.faculty;
                    document.getElementById('edit_phone').value = data.phone;

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    alert('Error loading user data. Please try again.');
                })
                .finally(() => {
                    loadingToast.hide();
                });
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" name="user_id" value="${userId}">
        `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function updateBooking(bookingId, status) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
        <input type="hidden" name="action" value="update_booking">
        <input type="hidden" name="booking_id" value="${bookingId}">
        <input type="hidden" name="approval" value="${status}">
    `;
            document.body.appendChild(form);
            form.submit();
        }

        function editRoom(roomId) {
            // Show loading state
            const loadingToast = new bootstrap.Toast(document.createElement('div'));
            loadingToast.show();

            fetch(`get_room.php?id=${roomId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the modal fields
                    document.getElementById('edit_room_id').value = data.id;
                    document.getElementById('edit_room_name').value = data.name;
                    document.getElementById('edit_room_block').value = data.block;
                    document.getElementById('edit_room_unit').value = data.unit;
                    document.getElementById('edit_room_type').value = data.type;
                    document.getElementById('edit_room_status').value = data.status;
                    document.getElementById('edit_room_max_persons').value = data.max_persons;

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching room data:', error);
                    alert('Error loading room data. Please try again.');
                })
                .finally(() => {
                    loadingToast.hide();
                });
        }

        function deleteRoom(roomId) {
            if (confirm('Are you sure you want to delete this room?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
            <input type="hidden" name="action" value="delete_room">
            <input type="hidden" name="room_id" value="${roomId}">
        `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Add chart.js for analytics
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch monthly booking data for chart
            fetch('get_monthly_bookings.php')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('bookingsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.map(item => item.month),
                            datasets: [{
                                label: 'Monthly Bookings',
                                data: data.map(item => item.count),
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>

</body>

</html>