<?php
    session_start();
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = "guest";
    }
    
?>

<!doctype html>
<html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/public/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
        <title>User Profile</title>
        <script src="/public/script.js" defer></script>
        <script src="userprofilescript.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        

    </head>
    <body>
        <header>
            <nav class="navbar">
                <span class="hamburger-btn material-symbols-rounded" style="color:black">Menu</span>
                    <a href="#" class="logo">
                        <h2>Welcome, <?php echo $_SESSION["user"] ?>!</h2>
                    </a>
                    <ul class="links">
                        <span class="close-btn material-symbols-rounded">Close</span>
                        <li><a href="/public/index.php">Home</a></li>
                        <li><a href="/public/user/userprofile.php">View Profile</a></li>
                        <li><a href="/public/API/booking.php">Make a Booking</a></li>
                        <li><a href="/public/API/viewbooking.php">View All Booking</a></li>
                    </ul>
                    <?php //nel ubah ni supaya dia logout jaa sbab booking will always available for logged in user only
                        if($_SESSION["user"] === "guest"){
                            echo '<button class="login-btn">Log In</button>';
                        } else {
                            echo '<button class="logout-btn">Log Out</button>';
                        }
                    ?>
            </nav>
            
        </header>

        <main >
            <h1 data-aos="zoom-in">User Profile</h1>
            <div style="height: 650px">
                <div class="userprofile" data-aos="flip-right">
                    <div class="profile-card" >
                        <div class="profile-header">
                            <img src="/public/img/blank_profile_pic.png" alt="User profile picture" class="profile-image">
                            <h2 class="profile-name">[USER FULL NAME]</h2>
                            <p class="profile-bio">[USER BIO]</p>
                            

                            <div class="profile-details">
                                <div class="box">
                                    <div class="row">
                                        <span style="color: white"><strong>Email:</strong></span>
                                        <div class="input">[XXX]</div>
                                    </div>
                                    <div class="row">
                                        <span style="color: white"><strong>Matric Num:</strong></span>
                                        <div class="input">[XXX]</div>
                                    </div>
                                    <div class="row">
                                        <span style="color: white"><strong>Phone Number:</strong></span>
                                        <div class="input">[XXX]</div>
                                    </div>
                                    <div class="row">
                                        <span style="color: white"><strong>Residential Block:</strong></span>
                                        <div class="input">[XXX]</div>
                                    </div>
                                    <div class="row">
                                        <span style="color: white"><strong>Faculty</strong></span>
                                        <div class="input">[XXX]</div>
                                    </div>

                                    <div class="button-wrap-edit" style="border-top: 1px solid #eee; justify-content: center; ">
                                        <span class="edit-profile-btn" id="edit-profile-btn"><img src="/public/img/edit_icon.png" style="height: 30px; width: 30x;">Edit Profile</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flip-box-container">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="card-title">Student Lounge Booking Stats</h2>
                                                <p class="card-description">January-December</p>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                        <canvas id="barChart" style="height:500px;width: content-box;"></canvas>
                                        </div>
                                        <div class="card-footer">
                                            <div class="trend">
                                                <span>Total Hour Spent on Student Lounge</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flip-box-back">
                                        <div class="edit-profile">
                                            <h2>Edit Profile</h2>
                                          <form action="userprofile.php" method="post" enctype="multipart/form-data">
                                                <label for="name">Name:</label>
                                                <input type="text" id="name" name="name" placeholder="Enter name"><br>

                                                <label for="email">Email:</label>
                                                <input type="email" id="email" name="email" placeholder="Enter email"><br>

                                                <label for="faculty">Faculty:</label>
                                                <input type="text" id="faculty" name="faculty" placeholder="Enter faculty"><br>

                                                <label for="matric">Matric Number:</label>
                                                <input type="text" id="matric" name="matric" placeholder="Enter matric number"><br>

                                                <label for="phone">Phone Number:</label>
                                                <input type="text" id="phone" name="phone" placeholder="Enter phone number"><br>

                                                <label for="block">Residential Block:</label>
                                                <input type="text" id="block" name="block" placeholder="Enter block"><br>

                                                <label for="bio">Bio:</label>
                                                <input type="text" id="bio" name="bio" placeholder="Enter bio (Not more than 10 words)"><br>

                                                <label for="profile-pic">Profile Picture:</label>
                                                <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
                                                
                                                <div class="button-wrap">
                                                    <button class="save-profile-btn" id="save-edit"><img src="/public/img/save_icon.png" style="height: 30px; width: 30x;">Save</button>
                                                    <button class="cancel-profile-btn" id="cancel-edit"><img src="/public/img/cancel-icon.png" style="height: 30px; width: 30x;">Cancel</button>
                                                </div>
                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="footer-section about">
                    <h1 class="logo-text">KOLEJ RAFFLESIA, UNIMAS<br><img src="/public/img/roffo-logo.png" style="height: 100px; width:100px;"></h1>
                    <p>
                        Universiti Malaysia Sarawak, 94300 Kota Samarahan, Sarawak, Malaysia
                    </p>
                    <div class="contact">
                        <span><i class="fas fa-phone"></i> &nbsp; 082-370086</span>
                        <span><i class="fas fa-envelope"></i> &nbsp; <a href="https://www.unimas.my/">https://www.unimas.my/</a></span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>