document.addEventListener('DOMContentLoaded', function() {
    let holidaysPage = 1; 
    let holidaysTotalPages = 0; 

    const holidaysTableBody = document.getElementById('reservations-table-body');
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

    function updateTableBodyHolidays(holidays) {
        holidaysTableBody.innerHTML = '';
        holidays.forEach(holiday => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${holiday.id}</td>
                <td>${holiday.DATE}</td>
                <td>${holiday.restaurant_name}</td>
                <td class="action">
                    <a class="btn-edit" href="http://localhost/holiday_update_form/?id=${holiday.id}">ویرایش</a>
                    <a class="btn-delete" href="http://localhost/holidays/${holiday.id}/delete">حذف</a>
                </td>
            `;
            holidaysTableBody.appendChild(row);
        });
    }

    function updatePagination(currentPage, totalPages) {
        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    prevButton.addEventListener('click', () => {
        if (holidaysPage > 1) {
            holidaysPage--;
            fetchData(`http://localhost/api/holidays/?page=${holidaysPage}`, 
                       updateTableBodyHolidays, 
                       'reservations-table', 
                       'pagination', 
                       page => holidaysPage = page, 
                       totalPages => holidaysTotalPages = totalPages);
        }
    });

    nextButton.addEventListener('click', () => {
        if (holidaysPage < holidaysTotalPages) {
            holidaysPage++;
            fetchData(`http://localhost/api/holidays/?page=${holidaysPage}`, 
                       updateTableBodyHolidays, 
                       'reservations-table', 
                       'pagination', 
                       page => holidaysPage = page, 
                       totalPages => holidaysTotalPages = totalPages);
        }
    });

    searchBtn.addEventListener('click', function() { 
        const query = searchQueryInput.value.trim();
        fetchData(`http://localhost/api/holidays/?page=${holidaysPage}`, 
                   updateTableBodyHolidays, 
                   'reservations-table', 
                   'pagination', 
                   page => holidaysPage = page, 
                   totalPages => holidaysTotalPages = totalPages, 
                   query);
    });

    fetchData(`http://localhost/api/holidays/?page=${holidaysPage}`, 
               updateTableBodyHolidays, 
               'reservations-table', 
               'pagination', 
               page => holidaysPage = page, 
               totalPages => holidaysTotalPages = totalPages);
});