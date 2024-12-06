document.addEventListener('DOMContentLoaded', function() {

    let userPage = 1; 
    let userTotalPages = 0; 
    const userTableBody = document.getElementById('user-table-body');
    const pageInfo1 = document.getElementById('page-info');
    const prevButton1 = document.getElementById('prev-page');
    const nextButton1 = document.getElementById('next-page');

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
                    <a  href="http://localhost/user_update_form/?id=${user.id} class="btn-edit" data-id="${user.id}">ویرایش</a>
                    <a href="http://localhost/users/${user.id}/delete" class="btn-delete">حذف</a>
                </td>
            `;

            userTableBody.appendChild(row);
        });
    }

    function updatePagination(currentPage, totalPages, paginationElementId) {
        let pageInfo, prevButton, nextButton;
        pageInfo = pageInfo1;
        prevButton = prevButton1;
        nextButton = nextButton1;

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


    fetchData(`http://localhost/api/load_users/?page=${userPage}`, updateTableBodyUsers, 'user-table', 'pagination1', page => userPage = page, totalPages => userTotalPages = totalPages);
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
document.getElementById("updateButton").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./pages/User/user_update_form.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("updateModal").innerHTML = xhr.responseText;
            document.getElementById("updateModal").style.display = "block";
        }
    }
    xhr.send();
});
