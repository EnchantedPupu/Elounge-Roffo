<?php
    session_start();
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = "guest";
    }
    
?>

<!doctype html>
<html lang="en">
    <head>
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
        <script src="bookingForm.js" defer></script>
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
            <h1 data-aos="zoom-in">Student Lounge Booking Form</h1>
            <div style="height: 550px">
                <div class="bookingform" data-aos="flip-right">
                    
                    <div class="formbold-form-wrapper">
                        <form action="booking.php" id="book" method="post">
                            
                            <div class="formbold-steps">
                                <ul>
                                    <li class="formbold-step-menu1 active">
                                        <span>1</span>
                                        Student Information
                                    </li>
                                    <li class="formbold-step-menu2">
                                        <span>2</span>
                                        Booking Details
                                    </li>
                                    <li class="formbold-step-menu3">
                                        <span>3</span>
                                        Room Details
                                    </li>
                                    <li class="formbold-step-menu4">
                                        <span>4</span>
                                        Extra Request
                                    </li>
                                    <li class="formbold-step-menu5">
                                        <span>5</span>
                                        Preview Booking
                                    </li>
                                </ul>
                            </div>
                            <!-- Student Information -->
                            <div class="formbold-form-step-1 active" data-aos="flip-right">
                                <div class="formbold-input-flex">
                                    <div>
                                        <label for="fullname" class="formbold-form-label">Full Name</label>
                                        <input type="text" name="fullname" id="fullname" class="formbold-form-input" placeholder="John Doe"/>
                                    </div>
                                    <div>
                                        <label for="email" class="formbold-form-label">Email</label>
                                        <input type="email" name="email" id="email" class="formbold-form-input" placeholder="thisisemail@domain.com"/>
                                    </div>
                                    
                                </div>
                                <div class="formbold-input-flex">
                                    <div>
                                        <label for="phone" class="formbold-form-label">Phone Number</label>
                                        <input type="phone" name="phone" id="phone" class="formbold-form-input" placeholder="012-3456789"/>
                                    </div>
                                    <div>
                                        <label for="studentid" class="formbold-form-label">Student ID</label>
                                        <input type="studentid" name="studentid" id="studentid" class="formbold-form-input" placeholder="12345"/>
                                    </div>
                                    
                                </div>
                                
                            </div>

                            <!-- Booking Details -->
                            <div class="formbold-form-step-2" data-aos="flip-right">
                                <div class="formbold-input-flex">
                                    <div>
                                        <label for="date" class="formbold-form-label">Date</label>
                                        <input type="date" name="date" id="date"  class="formbold-form-input" placeholder="DD/MM/YYYY"/>
                                    </div>
                                    <div>
                                        <label for="time" class="formbold-form-label">Time</label>
                                        <input type="time" name="time" id="time" class="formbold-form-input" placeholder="HH:MM"/>
                                    </div>
                                </div>
                                <div class="formbold-input-flex">
                                    <div>
                                        <label for="duration" class="formbold-form-label">Duration (Hour)</label>
                                        <input type="number" name="duration" id="duration" class="formbold-form-input" placeholder="N"/>
                                    </div>
                                    <div>
                                        <label for="purpose" class="formbold-form-label">Purpose</label>
                                        <input type="text" name="purpose" id="purpose" class="formbold-form-input" placeholder="Study"/>
                                    </div>
                                </div>
                            </div>

                            <div class="formbold-form-step-3" data-aos="flip-right">
                                <div class="formbold-input-flex">
                                    <div>
                                        <label for="roomtype" class="formbold-form-label">Room Type</label>
                                        <select name="roomtype" id="roomtype" class="formbold-form-input">
                                            <option value="female">Female Only Lounge</option>
                                            <option value="unisex">Unisex Lounge</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="roomselect" class="formbold-form-label">Room Selection</label>
                                        <select name="roomselect" id="roomselect" class="formbold-form-input">
                                            <option value="Room A">Room A</option>
                                            <option value="Room B">Room B</option>
                                            <option value="Room C">Room C</option>
                                            <option value="Room D">Room D</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="formbold-input-flex">
                                    
                                    <div>
                                        <label for="numstudents" class="formbold-form-label">Number of Student(s)</label>
                                        <input type="number" name="numstudents" id="numstudents" class="formbold-form-input"placeholder="N"/>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- Extra Request !-->
                            <div class="formbold-form-step-4" data-aos="flip-right">
                                <div>
                                    <label for="extra" class="formbold-form-label">Extra Request (Separated with ',')</label>
                                    <textarea rows="6" name="extra" id="extra" placeholder="Extra Extension, Extra Chair, Beverages..." class="formbold-form-input"></textarea>
                                </div>
                            </div>

                            <!-- Booking Summary !-->
                            <div class="formbold-form-step-5" data-aos="flip-right">
                                <div>
                                    <div class="title" style="text-decoration: underline">
                                            <h2>Booking Summary</h2>
                                            <br>
                                    </div>
                                    <div class="formbold-form-summary">
                                        
                                        <br>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Name:</span>
                                            <div class="input"><span id="summary-name">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Date:</span>
                                            <div class="input"><span id="summary-date">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Time:</span>
                                            <div class="input"><span id="summary-time">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Duration (Hour):</span>
                                            <div class="input"><span id="summary-duration">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Purpose:</span>
                                            <div class="input"><span id="summary-purpose">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Room:</span>
                                            <div class="input"><span id="summary-room">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Number of Students:</span>
                                            <div class="input"><span id="summary-no">[NOT PROVIDED]</span></div>
                                        </div>
                                        <div class="summary-item">
                                            <span class="formbold-form-summary-label">Extra Request:</span>
                                            <div class="input"><span id="summary-extra">[NOT PROVIDED]</span></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <p>*The booking summary will be sent to your email</p>
                            </div>
                            
                            
                            <div class="formbold-form-btn-wrapper">
                                <button class="formbold-back-btn" data-aos="zoom-in" >
                                    Back
                                </button>

                                <button class="formbold-btn" data-aos="zoom-in" type="submit">
                                    Next Step
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1675_1807)">
                                            <path d="M10.7814 7.33312L7.20541 3.75712L8.14808 2.81445L13.3334 7.99979L8.14808 13.1851L7.20541 12.2425L10.7814 8.66645H2.66675V7.33312H10.7814Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1675_1807">
                                                <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        
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
