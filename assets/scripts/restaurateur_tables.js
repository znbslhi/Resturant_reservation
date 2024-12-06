document.addEventListener('DOMContentLoaded', function() {
    let tablePage = 1;
    let tableTotalPages = 0;
    const tableTableBody = document.getElementById('tables-table-body');
    const pageInfo = document.getElementById('page-info');
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    const searchQueryInput = document.getElementById('search-query');
    const searchBtn = document.getElementById('search-btn'); 

    function fetchDataTables(url, updateTableBody, tableElementId, paginationElementId, currentPageSetter, totalPagesSetter,query="") {
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

    function updateTableBodyTables(tables) {
        tableTableBody.innerHTML = '';
        tables.forEach(table => {
            const row = document.createElement('tr');
            let status;
            if (table.status=='Available') {
                status = 'فعال';
            } else {
                status = 'غیرفعال';
            }
            row.innerHTML = `
                <td>${table.id}</td>
                <td>${table.restaurant_name}</td>
                <td>${table.capacity}</td>
                <td>${table.start_time}</td>
                <td>${table.end_time}</td>
                <td>${status}</td>
                <td class="action">
                    <a href="http://localhost/table_update_form/?id=${table.id}" class="edit-table" data-id="${table.id}">ویرایش</a>
                    <a href="http://localhost/tables/${table.id}/delete">حذف</a>
                </td>
            `;

            tableTableBody.appendChild(row);
        });
    }

    function updatePagination(currentPage, totalPages) {
        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    prevButton.addEventListener('click', () => {
        if (tablePage > 1) {
            tablePage--;
            fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination', page => tablePage = page, totalPages => tableTotalPages = totalPages);
        }
    });

    nextButton.addEventListener('click', () => {
        if (tablePage < tableTotalPages) {
            tablePage++;
            fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination', page => tablePage = page, totalPages => tableTotalPages = totalPages);
        }
    });
    searchBtn.addEventListener('click', function() { 
        const query = searchQueryInput.value.trim();
        fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, 
                    updateTableBodyTables, 
                   'tables-table', 
                   'pagination', 
                   page => tablePage = page, 
                   totalPages => tableTotalPages = totalPages, 
                   query);
    });

    fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination', page => tablePage = page, totalPages => tableTotalPages = totalPages);

});
