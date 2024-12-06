document.addEventListener('DOMContentLoaded', function() {
    let restaurantPage = 1; 
    let restaurantTotalPages = 0; 

    const restaurantTableBody = document.getElementById('restaurants-table-body');
    const pageInfo = document.getElementById('page-info');
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    const searchQueryInput = document.getElementById('search-query');
    const searchBtn = document.getElementById('search-btn'); 

    function fetchData(url, updateTableBody, tableElementId, paginationElementId, currentPageSetter, totalPagesSetter, query="") {
        if (query) {
            url += `&query=${encodeURIComponent(query)}`;
        }
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
                <td>${restaurant.NAME}</td>
                <td><button class="view-details" data-id="${restaurant.id}">نمایش جزئیات</button></td>
                <td>${restaurant.reserved_counts}</td>
                <td class="action">
                    <a class="btn-edit" href="http://localhost/restaurant_update_form/?id=${restaurant.id}">ویرایش</a>
                    <a class="btn-delete" href="http://localhost/restaurants/${restaurant.id}/delete">حذف</a>
                </td>
            `;
            restaurantTableBody.appendChild(row);
        });
    }

    function updatePagination(currentPage, totalPages) {
        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    prevButton.addEventListener('click', () => {
        if (restaurantPage > 1) {
            restaurantPage--;
            fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, 
                       updateTableBodyRestaurants, 
                       'restaurants-table', 
                       'pagination', 
                       page => restaurantPage = page, 
                       totalPages => restaurantTotalPages = totalPages);
        }
    });

    nextButton.addEventListener('click', () => {
        if (restaurantPage < restaurantTotalPages) {
            restaurantPage++;
            fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, 
                       updateTableBodyRestaurants, 
                       'restaurants-table', 
                       'pagination', 
                       page => restaurantPage = page, 
                       totalPages => restaurantTotalPages = totalPages);
        }
    });

    searchBtn.addEventListener('click', function() { 
        const query = searchQueryInput.value.trim();
        fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, 
                   updateTableBodyRestaurants, 
                   'restaurants-table', 
                   'pagination', 
                   page => restaurantPage = page, 
                   totalPages => restaurantTotalPages = totalPages, 
                   query);
    });

    fetchData(`http://localhost/api/restaurants/?page=${restaurantPage}`, 
               updateTableBodyRestaurants, 
               'restaurants-table', 
               'pagination', 
               page => restaurantPage = page, 
               totalPages => restaurantTotalPages = totalPages);
});
