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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"> defer</script>
    </head>
    <body>
        <header>
            <nav class="navbar">
                <span class="hamburger-btn material-symbols-rounded">Menu</span>
                <a href="#" class="logo">
                    <img src="img/unimas-logo.png" alt="logo">
                    <h2>Welcome User!</h2>
                </a>
                <ul class="links">
                    <span class="close-btn material-symbols-rounded">Close</span>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Map</a></li>
                    <li><a href="#">New Booking</a></li>
                </ul>
                <button class="login-btn">Log In</button>
            </nav>
        </header>

        

        <div class="blur-bg-overlay"></div>
        <div class="form-popup">
            <span class="close-btn material-symbols-rounded">Close</span>

            <div class="form-box login">
                <div class="form-content">
                    <h2>LOGIN</h2>
                    <form action="#">
                        <div class="input-field">
                            <input type="text" required>
                            <label>Email</label>
                        </div>
                        <div class="input-field">
                            <input type="password" required>
                            <label>Password</label>
                        </div>
                        <a href="#" id="forgot-pass-link">Forgot Password?</a>
                        <button type="submit">Log In</button>
                    </form>
                    <div class="bottom-link">
                        New here? Register Here!
                        <a href="#" id="register-link">Signup</a>
                    </div>
                </div>
            </div>
            <div class="form-box signup">
                <div class="form-content">
                        <h2>REGISTER</h2>
                        <form action="#">
                            <div class="input-field">
                                <input type="text" required>
                                <label>Enter Email</label>
                            </div>
                            <div class="input-field">
                                <input type="password" required>
                                <label>Create Password</label>
                            </div>
                            <div class="input-field">
                                <input type="password" required>
                                <label>Confirm Password</label>
                            </div>
                            <button type="submit">Log In</button>
                        </form>
                        <div class="bottom-link">
                            Already a user? <a href="#" id="login-link">Log In </a>Here!
                        </div>
                    </div>
                </div>
            </div>
            
    </body>
</html>
