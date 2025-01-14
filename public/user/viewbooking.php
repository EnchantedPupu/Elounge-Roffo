<!doctype html>
<html lang="en">
    <head>
        <title>View Booking Page</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/public/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="/public/script.js" defer></script>
        <script src="/public/scripts/viewbooking.js" defer></script>

    </head>
    <body>
        <?php include 'header.php'; ?>
        
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
                                <div class="header-item"><a id="action" class="filter-link ">Action</a></div>
                            </div>
                            <div class="table-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer >
            <?php include 'footer.php'; ?>
        </footer>
    
    </body>
                        
</html>

