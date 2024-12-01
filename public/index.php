<?php
    session_start();
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = "guest";
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container-fluid p-0">
            <!-- Top Bar -->
            <div class="row bg-light py-3 px-4 align-items-center">
                
                <div class="col-auto">
                    <span>Welcome, <strong><?php echo $_SESSION["user"]; ?></strong></span>
                </div>
                <div class="col-auto ms-auto">
                <a href="#" class="btn btn-modern me-2">Edit Profile</a>
                    <a href="#" class="btn btn-modern me-2">New Booking</a>
                    <a href="#" class="btn btn-modern me-2">View Booking History</a>
                    <a href="#" class="btn btn-modern me-2">About Us</a>
                    <a href="#" class="btn btn-modern">Contact Us</a>
                </div>
                <div class="col-auto">
                    <?php 
                        if ($_SESSION["user"] == "guest") {
                            echo '<a href="user/login.php" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828479.png" alt="Login Icon" style="width: 16px; height: 16px; margin-right: 4px;">
                                Log In
                            </a>';
                        }
                        else{
                            echo '<a href="user/logout.php" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828479.png" alt="Logout Icon" style="width: 16px; height: 16px; margin-right: 4px;">
                                Log Out
                            </a>';
                        }
                    ?>
                </div>
            </div>
            <!-- Main Content -->
            <div class="row">
                <div class="col p-0">
                    <div class="main-content d-flex flex-column justify-content-center align-items-center text-black" style="height: 100vh; background-image: url('bg-pic.png'); background-size: cover; background-position: center; ">
                        <div class="content-box text-center p-4">
                            <h1 class="display-4 text-center">Student Lounge e-Booking System</h1>
                            <h2 class="mt-3">KOLEJ RAFFLESIA</h2>
                            <p>UNIVERSITI MALAYSIA SARAWAK</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
