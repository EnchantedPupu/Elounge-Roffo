<?php
session_start();
if (!isset($_SESSION["user"])) {
    $_SESSION["user"] = "guest";
}
?>
<div class="alert-box" id="alert-box">
    <span class="close-btn" id="alert-close">&times;</span>
    <p id="alert-msg"></p>
</div>
<header>
    <nav class="navbar">

        <span class="hamburger-btn material-symbols-rounded" style="color: black">Menu</span>
        <a href="#" class="logo">
            <h2>Hi, <?php echo explode(" ", $_SESSION["user"])[0]; ?>!</h2>
        </a>
        <?php
        if ($_SESSION["user"] === "guest") {

            echo '<ul class="links">
                        <span class="close-btn material-symbols-rounded">Close</span>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about-section">About Us</a></li>
                        <li><a href="#map-section">Map</a></li>
                        </ul>';
            echo '<button class="login-btn">Log In</button>';
        } else if ($_SESSION['user'] === 'admin') {
            header("Location: /public/user/admin.php");
        }
        else {

            echo '<ul class="links">
                        <span class="close-btn material-symbols-rounded">Close</span>
                        <li><a href="/public/index.php">Home</a></li>
                        <li><a href="/public/user/userprofile.php">View Profile</a></li>
                        <li><a href="/public/user/booking.php">Make a Booking</a></li>
                        <li><a href="/public/user/viewbooking.php">View My Booking</a></li>
                        </ul>';
            echo "<button class='logout-btn' id='logout-btn'>Log Out</button>
                              <script>
                                $('#logout-btn').on('click', function (event) {
                                    event.preventDefault();

                                    //send logout request
                                    $.ajax({
                                        url: '/public/user/logout.php',
                                        type: 'GET',
                                        success: function () {
                                            window.location.href = '/public/index.php';
                                        },
                                        error: function() {
                                            alert('An error occurred. Please try again!');
                                        }
                                    });
                                });
                              </script>";
        }
        ?>
    </nav>
</header>