<?php
    session_start();
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = "guest";
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Rafflesia Student Lounge eBooking</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js" defer></script>
    </head>
    <body>
        <header>
            <nav class="navbar">
                
                <span class="hamburger-btn material-symbols-rounded" style="color: black">Menu</span>
                <a href="#" class="logo" >
                    <h2>Welcome, <?php echo $_SESSION["user"] ?>!</h2>
                </a>
                <?php
                    if($_SESSION["user"] === "guest"){
                        
                        echo '<ul class="links">
                        <span class="close-btn material-symbols-rounded">Close</span>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about-section">About Us</a></li>
                        <li><a href="#map-section">Map</a></li>
                        </ul>';
                        echo '<button class="login-btn">Log In</button>';
                    } else {
                        
                        echo '<ul class="links">
                        <span class="close-btn material-symbols-rounded">Close</span>
                        <li><a href="/public/index.php">Home</a></li>
                        <li><a href="/public/user/userprofile.php">View Profile</a></li>
                        <li><a href="/public/API/booking.php">Make a Booking</a></li>
                        <li><a href="/public/API/viewbooking.php">View All Booking</a></li>
                        <li><a href="#about-section">About Us</a></li>
                        <li><a href="#map-section">Map</a></li>
                        </ul>';
                        echo '<button class="logout-btn" id="logout-btn">Log Out</button>';
                    }
                ?>
            </nav>
        </header>
        <div class ="home" id="home"></div>
        <main>
        
            <div>
                <h1 data-aos="zoom-in">Rafflesia Student Lounge</h1>
            </div>
            <br>
            
            <div class="container2" data-aos="fade-up">
                <div>
                    <div class="content2">
                        <h2>Library</h2>
                        <span>Fuel your mind</span>
                    </div>
                </div>
                <div>
                    <div class="content2">
                        <h2>Interaction</h2>
                        <span>Where ideas meet</span>
                    </div>
                </div>
                <div>
                    <div class="content2">
                        <h2>Assignment</h2>
                        <span>Turn tasks into triumphs</span>
                    </div>
                </div>
                <div>
                    <div class="content2">
                        <h2>Brainstorming</h2>
                        <span>Sparks of genius starts here</span>
                    </div>
                </div>    
                    

            </div>
            <br>
            <h4>Hover Me!</h4>
        </main>

        <div class="blur-bg-overlay"></div>
        <div class="form-popup">
            <span class="close-btn material-symbols-rounded" style="color:black">Close</span>

            <div class="form-box login">
                <div class="form-content">
                    <h2>LOGIN</h2>
                    <form action="user/login.php" id='login-form' method="post" >
                        <div class="input-field">
                            <input type="text" name="email" id="email" required>
                            <label>Email</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="password" required>
                            <label>Password</label>
                            <button type="button-icon" class="toggle-password" data-target="#password">
                                <img src="/public/img/hidden.png" style="height: 20px; width: 20px;" alt="Show/Hide Password" class="toggle-icon">
                            </button>
                        </div>
                        <br>
                        <a href="#" id="forgot-pass-link">Forgot Password?</a>
                        <button type="submit">Log In</button>
                    </form>
                    <div class="bottom-link">
                        New user? <a href="#" id="register-link">Register</a> Here!
                    </div>
                </div>
            </div>

            <div class="form-box signup">
                <div class="form-content">
                    <h2>REGISTER</h2>
                    <form action="index.php" id="sign-up" method="post" >
                        <div class="input-field">
                            <input type="text" name="emailReg" id="emailReg" >
                            <label>Enter Email</label>
                        </div>
                        <div class="input-field">   
                            <input type="password" name="passwordReg" id="passwordReg" required>
                            <label>Create Password</label>
                            <button type="button-icon" class="toggle-password" data-target="#passwordReg">
                                <img src="/public/img/hidden.png" style="height: 20px; width: 20px;" alt="Show/Hide Password" class="toggle-icon">
                            </button>
                        </div>
                        <div class="input-field">
                            <input type="password" name="confirmPasswordReg" id="confirmPasswordReg" required>
                            <label>Confirm Password</label>
                            <button type="button-icon" class="toggle-password" data-target="#confirmPasswordReg">
                                <img src="/public/img/hidden.png" style="height: 20px; width: 20px;" alt="Show/Hide Password" class="toggle-icon">
                            </button>
                        </div>
                        <br>
                        <span><h3>Select Gender</h3></span>
                        <div class="form-content">
                            <label class="radio-selection">
                                <input name="gender-selection" id="gender-selection" type="radio" value="male" required>
                                <span><img src="\public\img\male.png" alt="Male" style="width: 18px; height: 18px;">Male</span>
                            </label>
                            <label class="radio-selection">
                                <input name="gender-selection" id="gender-selection" type="radio" value="female" required>
                                <span><img src="\public\img\female.png" alt="Female" style="width: 18px; height: 18px;">Female</span>
                            </label>
                        </div>
                        <button type="submit">Sign Up</button>
                    </form>
                    <div class="bottom-link">
                        Already a user? <a href="#" id="login-link">Log In</a> Here!
                    </div>
                </div>
            </div>

            <div class="form-box forgot-password">
                <div class="form-content">
                    <h2>FORGOT PASSWORD</h2>
                    <form action="#">
                        <div class="input-field">
                            <input type="email" required>
                            <label>Email</label>
                        </div>
                        <button type="submit">Send Verification</button>
                    </form>
                    <div class="bottom-link">
                        Already remember your password? <a href="#" id="login-link">Log In</a> Here!
                    </div>
                </div>
            </div>
        </div>
        
        <footer >
            <br>
            <div class="main" id="about-section">
                <h1>About Us</h1>
            </div>
            <section class="section-bottom">
                <div class="content">
                    <img src="/public/img/roffo-view.jpg" style="height:450px; width:450px;" alt="pic" data-aos="fade-right" data-aos-once="false">
                    <p data-aos="fade-left" data-aos-once="false">
                        Rafflesia Residential College, or Kolej Rafflesia, is one of the residential accommodations at UNIMAS, providing a comfortable and community-oriented living environment for students. It offers shared domitary-style rooms equipped with basic amenities, along with facilities like study areas, recreational spaces, a cafeteria, Wi-Fi, and laundry services. Strategically located within the campus, it allows easy access to academic buildings and other university resources, by bus provided by UNIMAS and Maria Transport Company. 
                    </p>
                </div>
            </section>
            <section class="section-bottom" id="map-section">
                <div class="content">
                    
                    <p data-aos="fade-right" data-aos-once="false">
                        Rafflesia Student Lounge is located at the heart of Rafflesia Residential College, Block N, the lounge is strategically positioned to ensure convenient access from all residential blocks. Conveniently situated right across from the mini mart, "Rumah Kita", allowing students to grab some refreshments before engaging in study-related activites.
                    </p>
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.847734490682!2d110.4555!3d1.44625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7b1b1b1b1b1%3A0x0!2zMSDCsDI2JzQ1LjUiTiAxMTDCsDI3JzE5LjgiRQ!5e0!3m2!1sen!2smy!4v1633072800000!5m2!1sen!2smy"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" data-aos="fade-left" data-aos-once="false"></iframe>
                </div>
            </section>
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
