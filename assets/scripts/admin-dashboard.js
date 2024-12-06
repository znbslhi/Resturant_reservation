document.addEventListener('DOMContentLoaded', function() {

    let userPage = 1; 
    let userTotalPages = 0; 

    let restaurantPage = 1; 
    let restaurantTotalPages = 0; 

    let reservationsPage = 1;
    let reservationsTotalPages = 0;

    const userTableBody = document.getElementById('user-table-body');
    const restaurantTableBody = document.getElementById('restaurants-table-body');
    const reservationsTableBody = document.getElementById('reservations-table-body');

    const pageInfo1 = document.getElementById('page-info');
    const prevButton1 = document.getElementById('prev-page');
    const nextButton1 = document.getElementById('next-page');

    const pageInfo2 = document.getElementById('page-info2');
    const prevButton2 = document.getElementById('prev-page2');
    const nextButton2 = document.getElementById('next-page2');

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
                updatePagination(data.page, data.totalpages, paginationElementId);

                document.getElementById(tableElementId).style.display = data.data.length === 0 ? 'none' : 'table';
                document.getElementById(paginationElementId).style.display = data.data.length === 0 ? 'none' : 'flex';
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateTableBodyUsers(users) {
        userTableBody.innerHTML = '';
        users.forEach(user => {
            if (user.user_type == 0) return; 
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.email}</td>
                <td>${user.user_type == 1 ? 'رستوراندار' : 'مشتری'}</td>
                <td class="action">
                    <a href="http://localhost/user_update_form/?id=${user.id} class="edit-user" data-id="${user.id}">ویرایش</a>
                    <a href="http://localhost/users/${user.id}/delete">حذف</a>
                </td>
            `;

            userTableBody.appendChild(row);
        });
    }

    function updateTableBodyRestaurants(restaurants) {
        restaurantTableBody.innerHTML = '';
        restaurants.forEach(restaurant => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${restaurant.id}</td>
                <td>${restaurant.owner_id}</td>
                <td>${restaurant.owner_email}</td>
                <td><button class="view-details" data-id="${restaurant.id}">نمایش جزئیات</button></td>
                <td>${restaurant.reserved_counts}</td>
                <td>
                    <a href="http://localhost/restaurant_update_form/?id=${restaurant.id}">ویرایش</a>
                    <a href="http://localhost/restaurants/${restaurant.id}/delete">حذف</a>
                </td>
            `;
            restaurantTableBody.appendChild(row);
        });
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
    function updatePagination(currentPage, totalPages, paginationElementId) {
        let pageInfo, prevButton, nextButton;

        switch (paginationElementId) {
            case 'pagination1':
                pageInfo = pageInfo1;
                prevButton = prevButton1;
                nextButton = nextButton1;
                break;
            case 'pagination2':
                pageInfo = pageInfo2;
                prevButton = prevButton2;
                nextButton = nextButton2;
                break;
            case 'pagination3':
                pageInfo = pageInfo3;
                prevButton = prevButton3;
                nextButton = nextButton3;
                break;
        }

        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }
  

    prevButton1.addEventListener('click', () => {
        if (userPage > 1) {
            userPage--;
            fetchData(`http://localhost/api/load_users/?page=${userPage}`, updateTableBodyUsers, 'user-table', 'pagination1', page => userPage = page, totalPages => userTotalPages = totalPages);
        }
    });

    nextButton1.addEventListener('click', () => {
        if (userPage < userTotalPages) {
            userPage++;
            fetchData(`http://localhost/api/load_users/?page=${userPage}`, updateTableBodyUsers, 'user-table', 'pagination1', page => userPage = page, totalPages => userTotalPages = totalPages);
        }
    });

    prevButton2.addEventListener('click', () => {
        if (restaurantPage > 1) {
            restaurantPage--;
            fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, updateTableBodyRestaurants, 'restaurants-table', 'pagination2', page => restaurantPage = page, totalPages => restaurantTotalPages = totalPages);
        }
    });

    nextButton2.addEventListener('click', () => {
        if (restaurantPage < restaurantTotalPages) {
            restaurantPage++;
            fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, updateTableBodyRestaurants, 'restaurants-table', 'pagination2', page => restaurantPage = page, totalPages => restaurantTotalPages = totalPages);
        }
    });
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

    fetchData(`http://localhost/api/load_users/?page=${userPage}`, updateTableBodyUsers, 'user-table', 'pagination1', page => userPage = page, totalPages => userTotalPages = totalPages);
    fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, updateTableBodyRestaurants, 'restaurants-table', 'pagination2', page => restaurantPage = page, totalPages => restaurantTotalPages = totalPages);
    fetchData(`http://localhost/api/reserves/?page=${reservationsPage}`, updateTableBodyReservations, 'reservations-table', 'pagination3', page => reservationsPage = page, totalPages => reservationsTotalPages = totalPages);
    var userModal = document.getElementById('user-modal');
    var closeBtn = userModal.querySelector('.close-btn');
    var modalBody = document.getElementById('user-modal-body');

    // نمایش مدال با AJAX
    document.querySelectorAll('.edit-user').forEach(button => {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            fetch('http://localhost/user_update_form/?id=' + userId)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                    userModal.style.display = 'block';
                })
                .catch(error => console.error('Error fetching form:', error));
        });
    });

    closeBtn.onclick = function() {
        userModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == userModal) {
            userModal.style.display = 'none';
        }
    }
});

