<!doctype html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/public/style.css">
        <script src="/public/script.js"></script>
    </head>
    <body>
        <div class="container-fluid p-0">
            <!-- Top Bar -->
            <div class="row bg-light py-3 px-4 align-items-center">
                
                <div class="col-auto">
                    <img src="/public/img/unimas-logo.png" alt="Unimas Logo" style="width: 45px; height: 45px; "> <span>&nbsp&nbspLog In Page</span>
                </div>
                <div class="col-auto ms-auto">
                    <a href="/public/index.php" class="btn btn-modern me-2">Home</a>
                    <a href="#" class="btn btn-modern me-2">About Us</a>
                    <a href="#" class="btn btn-modern me-2">Contact Us</a>
                </div>
                
            </div>
            <!-- Main Content -->
            <div class="row">
                <div class="animated"></div>
                <div class="col p-0">
                    <div class="main-content d-flex flex-column justify-content-center align-items-center text-black" style="height: 100vh; background-image: url('/public/img/bg-pic.png'); background-size: cover; background-position: center; ">
                        <div class="content-box text-center p-4">
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
                                    <a href="forgotpass.php" class="forgot-pass">Forgot Password? </a>
                                    <button type="submit">Log In</button>
                                </form>
                                <div class="bottom-link">
                                    Don't have an account?
                                    <a href="signup.php" id="register">Register</a>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
