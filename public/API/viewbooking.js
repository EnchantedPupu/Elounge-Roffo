document.addEventListener('DOMContentLoaded', function () {
    const filterDropdown = document.querySelector('#filter-dropdown');
    const sortDropdown = document.querySelector('#sort-dropdown');

    let bookings = [];

    function fetchBookings() {
        const tableContent = document.querySelector('.table-content');
        // Fetch data from the backend
        fetch('fetchbooking.php')
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
            `;
            tableContent.appendChild(row);
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

    
});
