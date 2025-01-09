AOS.init({
    duration: 1000, // Animation duration in milliseconds
});


const stepMenuOne = document.querySelector('.formbold-step-menu1');
const stepMenuTwo = document.querySelector('.formbold-step-menu2');
const stepMenuThree = document.querySelector('.formbold-step-menu3');
const stepMenuFour = document.querySelector('.formbold-step-menu4');
const stepMenuFive = document.querySelector('.formbold-step-menu5');

const stepOne = document.querySelector('.formbold-form-step-1');
const stepTwo = document.querySelector('.formbold-form-step-2');
const stepThree = document.querySelector('.formbold-form-step-3');
const stepFour = document.querySelector('.formbold-form-step-4');
const stepFive = document.querySelector('.formbold-form-step-5');

const formSubmitBtn = document.querySelector('.formbold-btn');
const formBackBtn = document.querySelector('.formbold-back-btn');

const previewName = document.getElementById('summary-name');
const previewDate = document.getElementById('summary-date');
const previewTime = document.getElementById('summary-time');
const previewDuration = document.getElementById('summary-duration');
const previewPurpose = document.getElementById('summary-purpose');
const previewRoomSel = document.getElementById('summary-room');
const previewNumStud = document.getElementById('summary-no');
const previewRequest = document.getElementById('summary-extra');

let currentStep = 1; // Tracks the current step

formSubmitBtn.addEventListener('click', function (event) {
    event.preventDefault();
    console.log(currentStep);

    if (currentStep === 1) {
        const email = document.getElementById('email').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter the correct format for email address to ensure you get the notification!');
            return false;
        }

        AOS.refresh();
        toggleSteps(stepMenuOne, stepMenuTwo, stepOne, stepTwo);
        formBackBtn.classList.add('active');
        currentStep++;
    } else if (currentStep === 2) {
        const duration = parseInt(document.getElementById('duration').value, 10);
        const date = document.getElementById('date').value;
        const today = new Date().toISOString().split('T')[0];

        if (duration < 1) {
            alert('Duration cannot be zero or negative!');
            return false;
        }
        if (date < today) {
            alert('Date should not be empty or in the past!');
            return false;
        }

        AOS.refresh();
        toggleSteps(stepMenuTwo, stepMenuThree, stepTwo, stepThree);
        currentStep++;
    } else if (currentStep === 3) {
        const numOfStudents = parseInt(document.getElementById('numstudents').value, 10);

        if (numOfStudents < 1) {
            alert('Number of students cannot be zero or negative!');
            return false;
        }

        toggleSteps(stepMenuThree, stepMenuFour, stepThree, stepFour);
        updatePreview();
        currentStep++;
    } else if (currentStep === 4) {
        updatePreview();
        toggleSteps(stepMenuFour, stepMenuFive, stepFour, stepFive);
        formSubmitBtn.textContent = 'Submit';
        currentStep++;
    } else if (currentStep === 5) {
        sendBookingData();
    }
});

function toggleSteps(menuCurrent, menuNext, stepCurrent, stepNext) {
    menuCurrent.classList.remove('active');
    menuNext.classList.add('active');
    stepCurrent.classList.remove('active');
    stepNext.classList.add('active');
}

function updatePreview() {
    const dateInput = document.querySelector('#date');
    const timeInput = document.querySelector('#time');
    previewDate.textContent = dateInput.value || '[NOT PROVIDED]';

    const timeValue = timeInput.value;
    if (timeValue) {
        const [hour, minute] = timeValue.split(':');
        const hourNum = parseInt(hour, 10);
        const isPM = hourNum >= 12;
        const formattedHour = ((hourNum + 11) % 12 + 1);
        previewTime.textContent = `${formattedHour}:${minute} ${isPM ? 'PM' : 'AM'}`;
    } else {
        previewTime.textContent = '[NOT PROVIDED]';
    }

    previewName.textContent = document.getElementById('fullname').value || '[NOT PROVIDED]';
    previewDuration.textContent = document.getElementById('duration').value || '[NOT PROVIDED]';
    previewPurpose.textContent = document.getElementById('purpose').value || '[NOT PROVIDED]';
    previewRoomSel.textContent = document.getElementById('roomselect').value || '[NOT PROVIDED]';
    previewNumStud.textContent = document.getElementById('numstudents').value || '[NOT PROVIDED]';
    previewRequest.textContent = document.getElementById('extra').value || '[NOT PROVIDED]';
}

function sendBookingData() {
    const bookingData = {
        fullname: document.getElementById('fullname').value || '[NOT PROVIDED]',
        studentId: document.getElementById('studentid').value || '[NOT PROVIDED]',
        roomType: document.getElementById('roomtype').value || '[NOT PROVIDED]',
        date: document.getElementById('date').value || '[NOT PROVIDED]',
        durationhour: document.getElementById('duration').value || '[NOT PROVIDED]',
        purpose: document.getElementById('purpose').value || '[NOT PROVIDED]',
        numPeople: document.getElementById('numstudents').value || '[NOT PROVIDED]',
        extra: document.getElementById('extra').value || '[NOT PROVIDED]',
        time: document.querySelector('#time').value || '[NOT PROVIDED]',
    };

    $.ajax({
        url: 'booking.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(bookingData),
        success: function (response) {
            alert('Booking successful!');
            window.location.href = response.redirectUrl || '/public/index.php';
        },
        error: function (xhr, status, error) {
            alert('Booking failed: ' + error);
            
        }
    });
}


formBackBtn.addEventListener('click', function (event) {
    formBackBtn.classList.add('active');
    event.preventDefault();
    
    
    if (currentStep === 2) {
        
        stepMenuTwo.classList.remove('active');
        stepMenuOne.classList.add('active');

        stepTwo.classList.remove('active');
        stepOne.classList.add('active');

        formBackBtn.classList.remove('active');
        currentStep--;
    } else if (currentStep === 3) {

        AOS.refresh();
        stepMenuThree.classList.remove('active');
        stepMenuTwo.classList.add('active');

        stepThree.classList.remove('active');
        stepTwo.classList.add('active');

        currentStep--;

        
    } else if (currentStep === 4) {

        
        stepMenuFour.classList.remove('active');
        stepMenuThree.classList.add('active');

        stepFour.classList.remove('active');
        stepThree.classList.add('active');
        
        currentStep--;
    
    }   else if (currentStep === 5) {

        stepMenuFive.classList.remove('active');
        stepMenuFour.classList.add('active');

        stepFive.classList.remove('active');
        stepFour.classList.add('active');

        formSubmitBtn.textContent = 'Next Step';
        currentStep--;
    }

    
});
