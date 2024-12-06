document.addEventListener('DOMContentLoaded', function() {
   /* var modal = document.getElementById('restaurant-modal');
    var closeBtn = document.querySelector('.close-btn');

    document.querySelectorAll('.view-details').forEach(button => {
        //modal.style.display = 'block';

        button.addEventListener('click', function() {
            var restaurantID = this.getAttribute('data-id');
            fetch('api/restaurant.php?id=' + restaurantID)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-body').innerHTML = `
                        <p><strong>نام:</strong> ${data.NAME}</p>
                        <p><strong>موقعیت:</strong> ${data.Location}</p>
                        <p><strong>توضیحات:</strong> ${data.Description}</p>
                        <p><strong>زمان شروع:</strong> ${data.start_time}</p>
                        <p><strong>زمان پایان:</strong> ${data.end_time}</p>
                        <p><strong>ایمیل مالک:</strong> ${data.owner_email}</p>
                    `;
                    modal.style.display = 'block';
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }*/

    let restaurantPage = 1; 
    let restaurantTotalPages = 0; 


    const restaurantTableBody = document.getElementById('restaurants-table-body');

    const pageInfo2 = document.getElementById('page-info2');
    const prevButton2 = document.getElementById('prev-page2');
    const nextButton2 = document.getElementById('next-page2');

  

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
                <td class="action">
                    <a href="http://localhost/restaurant_update_form/?id=${restaurant.id}">ویرایش</a>
                    <a href="http://localhost/restaurants/${restaurant.id}/delete">حذف</a>
                </td>
            `;
            restaurantTableBody.appendChild(row);
        });
    }
    

    function updatePagination(currentPage, totalPages) {
        let pageInfo, prevButton, nextButton;

        pageInfo = pageInfo2;
        prevButton = prevButton2;
        nextButton = nextButton2;

        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }
  

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


    fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, updateTableBodyRestaurants, 'restaurants-table', 'pagination2', page => restaurantPage = page, totalPages => restaurantTotalPages = totalPages);

});
