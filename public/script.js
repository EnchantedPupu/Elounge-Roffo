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

    // Form popup toggle
    const loginBtn = document.querySelector('.login-btn');
    const blurOverlay = document.querySelector('.blur-bg-overlay');
    const formPopup = document.querySelector('.form-popup');
    const formCloseBtns = document.querySelectorAll('.form-popup .close-btn');
    const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

    loginBtn.addEventListener('click', () => {
        document.body.classList.add('show-popup');
    });

    blurOverlay.addEventListener('click', () => {
        document.body.classList.remove('show-popup');
    });

    formCloseBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.body.classList.remove('show-popup');
        });
    });

    signupLoginLink.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            formPopup.classList[link.id === 'register-link' ? 'add' : 'remove']("show-signup");
        });
    });
});
