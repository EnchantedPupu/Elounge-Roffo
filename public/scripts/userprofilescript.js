$(document).ready(function () {
    AOS.init();

    document.getElementById("edit-profile-btn").addEventListener("click", function() {
        const flipBox = document.querySelector(".flip-box");
        flipBox.classList.toggle("flipped");
        this.style.display = 'none'; // Hide the edit button
    });

    const alertBox = document.getElementById('alert-box');
    const alertClose = document.getElementById('alert-close');
    const alertMsg = document.getElementById('alert-msg');
    const body = document.body;

    // Function to show the alert box with a message
    function showAlert(message, callback) {
        alertMsg.textContent = message;
        alertBox.style.display = 'block';
        
        const blurOverlay = document.createElement('div');
        blurOverlay.className = 'blur-overlay';
        blurOverlay.id = 'blur-overlay';
        body.appendChild(blurOverlay);

        setTimeout(() => {
            alertBox.style.display = 'none'; 
            const overlay = document.getElementById('blur-overlay');
            if (overlay) {
                overlay.remove();
            }
            if (callback) callback();
        }, 3000); // Show alert for 3 seconds
    }

    // Function to close the alert box
    function closeAlert() {
        alertBox.style.display = 'none';
        const overlay = document.getElementById('blur-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    // Close the alert box when the user clicks on <span> (x)
    alertClose.addEventListener('click', closeAlert);
    $("#save-edit").on("click", function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        //get form data for the edit-profile
        let formData = new FormData();

        formData.append("name", $("#name").val());
        formData.append("email", $("#email").val());
        formData.append("faculty", $("#faculty").val());
        formData.append("matric", $("#matric").val());
        formData.append("phone", $("#phone").val());
        formData.append("block", $("#block").val());
        formData.append("bio", $("#bio").val());
        formData.append("profile-pic", $("#profile-pic")[0].files[0]);

        let isValid = true;
        //form validation
        if (!$("#name").val().trim()) {
            showAlert("Please enter a name");
            isValid = false;
        }

        if (!$("#email").val().trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($("#email").val())) {
            showAlert("A valid email is required.");
            isValid = false;
        }
        if (!$("#faculty").val().trim()) {
            showAlert("Faculty is required.");
            isValid = false;
        }
        if (!$("#matric").val().trim() || !/^\d+$/.test($("#matric").val())) {
            showAlert("A valid matric number is required.");
            isValid = false;
        }
        if (!$("#phone").val().trim() || !/^\d{10,15}$/.test($("#phone").val())) {
            showAlert("A valid phone number is required.");
            isValid = false;
        }
        if (!$("#block").val().trim()) {
            showAlert("Block is required.");
            isValid = false;
        }
        if (!$("#bio").val().trim() || $("#bio").val().split(" ").length > 10) {
            showAlert("Bio should not exceed 10 words.");
            isValid = false;
        }

        if (!isValid) return;
        
        $.ajax({
            url: 'userprofile.php',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function(response) {
                showAlert("Profile updated successfully!");
                window.location.href = 'userprofile.php';
                
            },
            error: function(xhr, status, error) {
                console.error("Error: "+error);
                showAlert("There was an error updating the profile");
            }
        });
    });

    document.getElementById("cancel-edit").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent the default form submission
        const flipBox = document.querySelector(".flip-box");
        flipBox.classList.toggle("flipped");
        document.getElementById("edit-profile-btn").style.display = 'flex'; // Show the edit button
    });

    // Initialize Bar Chart (User Stats)
    const ctx = document.getElementById('barChart');

    if (ctx) {
        $.ajax({
            url: '/public/user/getBookingStats.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const chartData = data.map(row => ({
                    month: row.month,
                    desktop: row.total_hours
                }));

                const myChart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: chartData.map(row => row.month.slice(0, 3)),
                        datasets: [{
                            label: 'Total Hour',
                            data: chartData.map(row => row.desktop),
                            backgroundColor: 'hsl(215, 100%, 50%)',
                            borderRadius: 8,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        return chartData[context[0].dataIndex].month;
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 1000, // Animation duration in milliseconds
                            easing: 'linear', // Animation easing style
                        },
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: "+error);
                showAlert("There was an error retrieving the booking stats");
            }
        });
    } else {
        console.error('Canvas element with id "barChart" not found.');
    }
    
});