<?php
    session_start();
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = "Syl";
    }
    
?>

<!doctype html>
<html lang="en">
    <head>
        <title>View Booking Page</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/public/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="/public/script.js" defer></script>
        <script src="viewbooking.js" defer></script>

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
                    <li><a href="/public/user/userprofile.php">Edit Profile</a></li>
                    <li><a href="booking.php">Make a Booking</a></li>
                    <li><a href="viewbooking.php">View All Booking</a></li>
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
        
        <main>
            <h1 data-aos="zoom-in">Rafflesia Student Lounge</h1>
            <div style="height: 550px; width:1200px; align-items: center;"  >
                <div class="viewbooking" data-aos="flip-right" style="display: flex; flex-direction: column; width: 1200px; padding: 0px;">

                    <h2 style="padding-top: 20px">Booking History</h2>

                    <div class="container">
                        <div class="icon">
                            <span id="filter-icon">
                                <div class="option-wrapper">
                                    <img src ="/public/img/filter-icon.png" style="height: 20px; width: 20px">
                                    <select class="filter-dropdown" id="filter-dropdown">
                                        <option value="ALL">All</option>
                                        <option value="PENDING">Pending</option>
                                        <option value="APPROVED">Approved</option>
                                        <option value="REJECTED">Rejected</option>
                                    </select>
                                </div>
                            </span>
                            <span id="sort-icon">
                                <div class="option-wrapper">
                                    <img src="/public/img/sort-icon.png" style="height: 20px; width: 20px;">
                                    <select class="sort-dropdown" id="sort-dropdown">
                                        <option value="DATE">Date</option>
                                        <option value="STATUS">Status</option>
                                    </select>
                                </div>
                            </span> 
                        </div>
                        <div class="table">
                            <div class="table-header">
                                <div class="header-item"><a id="date" class="filter-link" >Date</a></div>
                                <div class="header-item"><a id="time" class="filter-link" >Time</a></div>
                                <div class="header-item"><a id="room" class="filter-link ">Room</a></div>
                                <div class="header-item"><a id="duration" class="filter-link" >Duration(Hour)</a></div>
                                <div class="header-item"><a id="purpose" class="filter-link " >Purpose</a></div>
                                <div class="header-item"><a id="status" class="filter-link ">Status</a></div>
                            </div>
                            <div class="table-content">
                                <div class="table-row">
                                    
                                    <div class="table-data">2024-11-11</div>
                                    <div class="table-data">22:00</div>
                                    <div class="table-data">Room A</div>
                                    <div class="table-data">2</div>
                                    <div class="table-data">Assignment</div>
                                    <div class="table-data">REJECTED</div>
                                </div>
                                <div class="table-row">
                                   
                                    <div class="table-data">2024-12-10</div>
                                    <div class="table-data">20:00</div>
                                    <div class="table-data">Room A</div>
                                    <div class="table-data">2</div>
                                    <div class="table-data">Study</div>
                                    <div class="table-data">APPROVED</div>
                                </div>
                                <div class="table-row">
                                    
                                    <div class="table-data">2024-12-05</div>
                                    <div class="table-data">11:00</div>
                                    <div class="table-data">Room C</div>
                                    <div class="table-data">3</div>
                                    <div class="table-data">Study</div>
                                    <div class="table-data">PENDING</div>
                                </div>
                                <div class="table-row">
                                    
                                    <div class="table-data">2024-11-11</div>
                                    <div class="table-data">22:00</div>
                                    <div class="table-data">Room A</div>
                                    <div class="table-data">2</div>
                                    <div class="table-data">Assignment</div>
                                    <div class="table-data">PENDING</div>
                                </div>
                                <div class="table-row">
                                    
                                    <div class="table-data">2024-11-11</div>
                                    <div class="table-data">22:00</div>
                                    <div class="table-data">Room A</div>
                                    <div class="table-data">2</div>
                                    <div class="table-data">Assignment</div>
                                    <div class="table-data">PENDING</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer >
            
            
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

