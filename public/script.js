document.addEventListener('DOMContentLoaded', () => {
    // Hamburger menu toggle
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const closeBtn = document.querySelector('.close-btn');
    const links = document.querySelector('.links');

    hamburgerBtn.addEventListener('click', () => {
        links.classList.toggle('show-menu'); // Show the menu
    });

    closeBtn.addEventListener('click', () => {
        links.classList.remove('show-menu'); // Hide the menu
    });

    AOS.init({
        duration: 1000, // Animation duration in milliseconds
        once: true, // Whether animation should happen only once - while scrolling down
    });

    // Smooth scroll functionality
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    $(document).ready(function () {
        // Toggle password visibility
        $('.toggle-password').on('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            
            const target = $(this).data('target');
            const input = $(target);
            const icon = $(this).find('.toggle-icon');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.attr('src', '/public/img/showed.png');
            }   else {
                input.attr('type', 'password');
                icon.attr('src', '/public/img/hidden.png');
            }
        })
    });

    
    //form validation and JSON data submission(register)
    $(document).ready(function () {
        $('#sign-up').on('submit', function (event) {
            event.preventDefault();

            //get form inputs
            const email = $('#emailReg').val().trim();
            const password = $('#passwordReg').val().trim();
            const confirmPassword = $('#confirmPasswordReg').val().trim();
            const gender = $('input[name="gender-selection"]:checked').val();

            //email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert("Please enter a valid email address!");
                return;
            }

            //password validation
            const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;
            if (!passwordRegex.test(password)) {
                showAlert('Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.');
                return;
            }

            //confirm password validation
            if (password !== confirmPassword) {
                showAlert("Password do not match! Please try again");
                return;
            }

            //gender selection validation
            if (!gender) {
                showAlert('Please choose your gender!');
                return;
            }

            //send registration data
            $.ajax({
                url: '/public/user/signup.php',
                type: 'GET',
                contentType: 'application/json',
                data: {
                    email: email,
                    password: password,
                    gender: gender,
                },
                success: function (response) {
                    if (response.message === 'success') {
                        showAlert('Registration Successful! Redirecting...', () => {
                            window.location.href = '/public/index.php';
                        });
                    }
                    else {
                        showAlert(response.message || 'An error occured. Please try again!');
                    }
                }
            })
        });
    })

    //form validation and JSON data submission(login)
    $(document).ready(function () {
        $('#login-form').on('submit', function (event) {
            event.preventDefault();

            //get form inputs
            const email = $('#email').val().trim();
            const password = $('#password').val().trim();

            //email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('Please enter a valid email address!');
                return;
            }

            //password validation
            if(password === '') {
                showAlert('Password cannot be empty!');
                return;
            }

            //send login data
            $.ajax({
                url: '/public/user/login.php',
                type: 'GET',
                contentType: 'application/json',
                data: {
                    email: email,
                    password: password,
                },
                success: function (response) {
                    if (response.message === 'success') {
                        showAlert('Login successful! Redirecting...', () => {
                            window.location.href = response.redirectUrl || '/public/index.php';
                        });
                    }   else {
                        showAlert(response.message || 'Invalid credentials! Please try again.');
                    }
                },
                error: function() {
                    showAlert('An error occured. Please try again!');
                }
            });
        });
    });

    // Form popup toggle
    const loginBtn = document.querySelector('.login-btn');
    const blurOverlay = document.querySelector('.blur-bg-overlay');
    const formPopup = document.querySelector('.form-popup');
    const formCloseBtns = document.querySelectorAll('.form-popup .close-btn');
    const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");
    const forgotPassLink = document.getElementById('forgot-pass-link');
    const registerLink = document.getElementById('register-link');

    // Ensure all forms are hidden initially
    formPopup.querySelectorAll('.form-box').forEach(form => form.style.display = 'none');

    loginBtn.addEventListener('click', () => {
        document.body.classList.add('show-popup');
        formPopup.querySelector('.login').style.display = 'block';
    });

    blurOverlay.addEventListener('click', () => {
        document.body.classList.remove('show-popup');
        formPopup.querySelectorAll('.form-box').forEach(form => form.style.display = 'none');
    });

    formCloseBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.body.classList.remove('show-popup');
            formPopup.querySelectorAll('.form-box').forEach(form => form.style.display = 'none');
        });
    });

    signupLoginLink.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            formPopup.querySelectorAll('.form-box').forEach(form => form.style.display = 'none');
            if (link.id === 'register-link') {
                formPopup.querySelector('.signup').style.display = 'block';
            } else {
                formPopup.querySelector('.login').style.display = 'block';
            }
        });
    });

    forgotPassLink.addEventListener('click', (e) => {
        e.preventDefault();
        formPopup.querySelectorAll('.form-box').forEach(form => form.style.display = 'none');
        formPopup.querySelector('.forgot-password').style.display = 'block';
    });

    // Modal box functionality
    

    // Select elements
    


    // Alert box functionality
    const alertBox = document.getElementById('alert-box');
    const alertClose = document.getElementById('alert-close');
    const alertMsg = document.getElementById('alert-msg');

    // Function to show the alert box with a message
    function showAlert(message, callback) {
        alertMsg.textContent = message;
        alertBox.style.display = 'block';
        setTimeout(() => {
            alertBox.style.display = 'none';
            if (callback) callback();
        }, 3000); // Show alert for 3 seconds
    }

    // Function to close the alert box
    function closeAlert() {
        alertBox.style.display = 'none';
    }

    // Close the alert box when the user clicks on <span> (x)
    alertClose.addEventListener('click', closeAlert);

    // Example usage of showAlert function (you can replace this with your own trigger)
    // showAlert('This is an alert message!');
    
});