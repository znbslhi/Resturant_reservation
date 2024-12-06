document.addEventListener('DOMContentLoaded', function() {

    let reservationsPage = 1;
    let reservationsTotalPages = 0;

    const reservationsTableBody = document.getElementById('reservations-table-body');

    const pageInfo3 = document.getElementById('page-info3');
    const prevButton3 = document.getElementById('prev-page3');
    const nextButton3 = document.getElementById('next-page3');



    function fetchData(url, updateTableBody, tableElementId, paginationElementId, currentPageSetter, totalPagesSetter) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                updateTableBody(data.data);
                currentPageSetter(data.page);
                totalPagesSetter(data.totalpages);
                updatePagination(data.page, data.totalpages);

                document.getElementById(tableElementId).style.display = data.data.length === 0 ? 'none' : 'table';
                document.getElementById(paginationElementId).style.display = data.data.length === 0 ? 'none' : 'flex';
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    
    function updateTableBodyReservations(reservations) {
        reservationsTableBody.innerHTML = '';
        reservations.forEach(reservation => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${reservation.reservation_id}</td>
                <td>${reservation.reserved_date}</td>
                <td>${JSON.parse(reservation.reserved_hours).join(', ')}</td>
                <td>${reservation.table_id}</td>
                <td>${reservation.table_capacity}</td>
                <td>${reservation.customer_email}</td>
                <td>${reservation.restaurant_name}</td>
                <td>${reservation.restaurant_owner_email}</td>
            `;
            reservationsTableBody.appendChild(row);
        });
    }
    function updatePagination(currentPage, totalPages) {
        let pageInfo, prevButton, nextButton;

        pageInfo = pageInfo3;
        prevButton = prevButton3;
        nextButton = nextButton3;

        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    prevButton3.addEventListener('click', () => {
        if (reservationsPage > 1) {
            reservationsPage--;
            fetchData(`http://localhost/api/reserves/?page=${reservationsPage}`, updateTableBodyReservations, 'reservations-table', 'pagination3', page => reservationsPage = page, totalPages => reservationsTotalPages = totalPages);
        }
    });

    nextButton3.addEventListener('click', () => {
        if (reservationsPage < reservationsTotalPages) {
            reservationsPage++;
            fetchData(`http://localhost/api/reserves/?page=${reservationsPage}`, updateTableBodyReservations, 'reservations-table', 'pagination3', page => reservationsPage = page, totalPages => reservationsTotalPages = totalPages);
        }
    });
    fetchData(`http://localhost/api/reserves/?page=${reservationsPage}`, updateTableBodyReservations, 'reservations-table', 'pagination3', page => reservationsPage = page, totalPages => reservationsTotalPages = totalPages);

});

