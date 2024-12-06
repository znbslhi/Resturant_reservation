document.addEventListener('DOMContentLoaded', function() {
    let tablePage = 1;
    let tableTotalPages = 0;
    const tableTableBody = document.getElementById('tables-table-body');
    const pageInfo3 = document.getElementById('page-info3');
    const prevButton3 = document.getElementById('prev-page3');
    const nextButton3 = document.getElementById('next-page3');

    function fetchDataTables(url, updateTableBody, tableElementId, paginationElementId, currentPageSetter, totalPagesSetter) {
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
                <td>${table.resturant_id}</td>
                <td>${table.restaurant_name}</td>
                <td>${table.owner_email}</td>
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
        let pageInfo, prevButton, nextButton;
        pageInfo = pageInfo3;
        prevButton = prevButton3;
        nextButton = nextButton3;

        pageInfo.textContent = `صفحه ${currentPage} از ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    prevButton3.addEventListener('click', () => {
        if (tablePage > 1) {
            tablePage--;
            fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination3', page => tablePage = page, totalPages => tableTotalPages = totalPages);
        }
    });

    nextButton3.addEventListener('click', () => {
        if (tablePage < tableTotalPages) {
            tablePage++;
            fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination3', page => tablePage = page, totalPages => tableTotalPages = totalPages);
        }
    });

    fetchDataTables(`http://localhost/api/load_tables/?page=${tablePage}`, updateTableBodyTables, 'tables-table', 'pagination3', page => tablePage = page, totalPages => tableTotalPages = totalPages);

});
