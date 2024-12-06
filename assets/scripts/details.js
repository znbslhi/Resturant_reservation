const hamburgerElm = document.getElementById('hamburger'); hamburgerElm.addEventListener('click', function() { var menu = document.getElementById('menu'); menu.classList.toggle('show');


// Toggle the color of the hamburger icon
if (menu.classList.contains('show')) {
    hamburgerElm.style.color = '#FFB918';
} else {
    hamburgerElm.style.color = ''; // Reset to original color
}
}); 

document.addEventListener("DOMContentLoaded", function() { 
    const mainImage = document.querySelector(".main-image .image"); 
    const albumItems = document.querySelectorAll(".album-item");


albumItems.forEach(item => {
    item.addEventListener("click", function() {
        // Create a temporary image to preload the new image
        const tempImage = new Image();
        tempImage.src = this.src;

        // When the image is loaded, update the main image source with a smooth transition
        tempImage.onload = function() {
            // Fade out the main image
            mainImage.style.opacity = 0;

            // Change the main image source after the fade out
            setTimeout(() => {
                mainImage.src = tempImage.src;

                // Fade in the main image
                mainImage.style.opacity = 1;
            }, 300); // This should match the CSS transition duration

            // Remove 'selected' class from all album items
            albumItems.forEach(i => i.classList.remove("selected"));

            // Add 'selected' class to the clicked album item
            item.classList.add("selected");
        };
    });
});

const modal = document.getElementById("reservation-modal");
const span = document.getElementsByClassName("close-btn")[0];
const btns = document.querySelectorAll(".btn-reserve");

function openModal(tableId) {
    if(!userID){
        window.location.href="http://localhost/login/"
    }else{
        const table = tableData[tableId - 1]; 
        if (table) {
            document.querySelector("#reservation-modal .table-info h2").innerHTML = `Table ${tableId}`;
            document.querySelector("#reservation-modal .table-info p:nth-of-type(1)").innerHTML = `Capacity: ${table.capacity} people`;
            document.querySelector("#reservation-modal .table-info p:nth-of-type(2)").innerHTML = `Services: ${table.features}`;
            document.querySelector("#reservation-modal .table-info p:nth-of-type(3)").innerHTML = `Timings: ${table.start_time} - ${table.end_time}`;
    
            modal.style.display = "block";
    
            const confirmReservationBtn = document.getElementById('confirm-reservation');
            confirmReservationBtn.setAttribute("data-table-id", tableId);
        } else {
            console.error("Table data not found");
        }
    }

}


btns.forEach(btn => {
    btn.addEventListener("click", function() {
        const tableId = parseInt(this.getAttribute("data-table-id"), 10);
        openModal(tableId);
    });
});

// بستن مودال
span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
});

function openModal() { document.getElementById("reservation-modal").style.display = "block"; }

function closeModal() { document.getElementById("reservation-modal").style.display = "none"; }

window.onclick = function(event) { 
    const modal = document.getElementById("reservation-modal"); 
    if (event.target == modal) { modal.style.display = "none";
 } } 
 
 const confirmReservationBtn = document.getElementById('confirm-reservation');

 confirmReservationBtn.addEventListener('click', function() {
     const date = document.getElementById('reservation-date').value;
     const startTime = document.getElementById('start-time').value;
     const duration = document.getElementById('duration').value;
     const tableId = parseInt(this.getAttribute("data-table-id"), 10);
     const requested_capacity = document.getElementById('requested_capacity').value;

 
     if (!date || !startTime || !duration || isNaN(tableId)) {
         alert("Please fill in all the required fields.");
         return;
     }

     const startDateTime = new Date(`${date}T${startTime}:00`);

     let times = [];

    for (let i = 0; i < duration; i++) {
        const time = new Date(startDateTime.getTime() + i * 3600*1000);  
        times.push(time.toTimeString().split(' ')[0]); 
    }

    const data = {
        restaurant_id:restaurantID,
        table_index: tableId,
        date: date,
        requestedTimes: times,
        user_id:userID,
        requestedCapacity:requested_capacity
    };

    fetch('http://localhost/api/reservation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        alert(data['message']) ;
        if(data['status']==200){
            window.location.href=`http://localhost/restaurants/${restaurantID}` ;
        }
    })
    .catch(error => console.error('Error:', error));
    
     
 });
 
 

