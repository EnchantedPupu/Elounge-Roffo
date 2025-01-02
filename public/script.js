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
                alert("Please enter a valid email address!");
                return;
            }

            //password validation
            const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;
            if (!passwordRegex.test(password)) {
                alert('Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.');
                return;
            }

            //confirm password validation
            if (password !== confirmPassword) {
                alert("Password do not match! Please try again");
                return;
            }

            //gender selection validation
            if (!gender) {
                alert('Please choose your gender!');
                return;
            }

            //send registration data
            $.ajax({
                url: '/public/index.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    password: password,
                    gender: gender
                }),
                success: function(response) {
                    if (response.success) {
                        alert('Registration Successful! Redirecting...');
                        window.location.href = response.redirectUrl || '/public/index.php';
                    }   else {
                        alert(response.message || 'Registration Failed! Please try again later!');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again later!');
                }
            });
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
                alert ('Please enter a valid email address!');
                return;
            }

            //password validation
            if(password === '') {
                alert('Password cannot be empty!');
                return;
            }

            //send login data
            $.ajax({
                url: '/public/index.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    password: password,
                }),
                success: function (response) {
                    if (response.success) {
                        alert('Login Successful! Redirecting...');
                        window.location.href = response.redirectUrl || '/public/user/login.php';
                    }   else {
                        alert(response.message || 'Invalid credentials! Please try again.');
                    }
                },
                error: function() {
                    alert('An error occured. Please try again!');
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

    // Select elements
    


    
});