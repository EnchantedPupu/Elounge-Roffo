document.addEventListener('DOMContentLoaded', function () {
    const filterDropdown = document.querySelector('#filter-dropdown');
    const sortDropdown = document.querySelector('#sort-dropdown');

    let bookings = [];

    function fetchBookings() {
        const tableContent = document.querySelector('.table-content');
        // Fetch data from the backend
        fetch('/public/user/fetchbooking.php')
            .then((response) => response.json())
            .then((data) => {
                bookings = data;
                renderTable(bookings, tableContent);
            })
            .catch((error) => {
                console.error('Error fetching booking data:', error);
            });
    }
    fetchBookings();

    function renderTable(data, tableContent) {
        tableContent.innerHTML = ''; // Clear current table rows
        data.forEach((booking) => {
            const row = document.createElement('div');
            row.classList.add('table-row');
    
            // Apply status-based background color
            let statusClass = '';
            if (booking.status === 'PENDING') statusClass = 'status-pending';
            else if (booking.status === 'APPROVED') statusClass = 'status-approved';
            else if (booking.status === 'REJECTED') statusClass = 'status-rejected';
    
            row.innerHTML = `
                <div class="table-data">${booking.date}</div>
                <div class="table-data">${booking.time}</div>
                <div class="table-data">${booking.room}</div>
                <div class="table-data">${booking.duration}</div>
                <div class="table-data">${booking.purpose}</div>
                <div class="table-data ${statusClass}">${booking.status}</div>
                <div class="table-data">
                    <button class="print-receipt" data-booking='${JSON.stringify(booking)}'>Print Receipt</button>
                </div>
            `;
    
            tableContent.appendChild(row);
        });

        // Attach event listeners after rendering
        document.querySelectorAll('.print-receipt').forEach((button) => {
            button.addEventListener('click', () => {
                const booking = JSON.parse(button.getAttribute('data-booking'));
                printReceipt(booking);
            });
        });
    }

    function filterBookings() {
        const filterValue = filterDropdown.value;
        const filteredBookings = bookings.filter(booking => booking.status === filterValue || filterValue === 'ALL');
        renderTable(filteredBookings, document.querySelector('.table-content'));
    }

    function sortBookings() {
        const sortValue = sortDropdown.value;
        let sortedBookings = [...bookings];
        if (sortValue === 'DATE') {
            sortedBookings.sort((a, b) => new Date(a.date) - new Date(b.date));
        } else if (sortValue === 'STATUS') {
            sortedBookings.sort((a, b) => a.status.localeCompare(b.status));
        }
        renderTable(sortedBookings, document.querySelector('.table-content'));
    }

    filterDropdown.addEventListener('change', filterBookings);
    sortDropdown.addEventListener('change', sortBookings);

    window.printReceipt = function (booking) {
        if (!booking) {
            alert('Error: Booking not found!');
            return;
        }

        // Create printable content
        const printableContent = `
            <html>
            <head>
                <title>Booking Receipt</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    h1 {
                        text-align: center;
                    }
                    .receipt {
                        margin: auto;
                        width: 80%;
                        border: 1px solid #ccc;
                        padding: 10px;
                        border-radius: 10px;
                    }
                    .receipt div {
                        margin: 10px 0;
                    }
                    .label {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <h1>Booking Receipt</h1>
                <div class="receipt">
                    <div><span class="label">Booking ID:</span> ${booking.id}</div>
                    <div><span class="label">Date:</span> ${booking.date}</div>
                    <div><span class="label">Time:</span> ${booking.time}</div>
                    <div><span class="label">Room:</span> ${booking.room}</div>
                    <div><span class="label">Duration:</span> ${booking.duration}</div>
                    <div><span class="label">Purpose:</span> ${booking.purpose}</div>
                    <div><span class="label">Status:</span> ${booking.status}</div>
                </div>
                <script>
                    window.print();
                </script>
            </body>
            </html>
        `;
    
        // Open a new window and write the content
        const newWindow = window.open('', '_blank');
        newWindow.document.open();
        newWindow.document.write(printableContent);
        newWindow.document.close();
    };
});
