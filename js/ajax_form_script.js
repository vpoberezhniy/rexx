document.getElementById('filterForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Fetch data from the server using AJAX
    fetch('filter_handler.php?' + new URLSearchParams(new FormData(this)))
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#resultsTable tbody');
            const totalPriceCell = document.querySelector('#totalPrice');
            tableBody.innerHTML = ''; // Clear previous results

            data.forEach(result => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>${result.employee_name}</td>
                        <td>${result.event_name}</td>
                        <td>${result.event_date}</td>
                        <td>${result.event_price}</td>
                    `;
                tableBody.appendChild(row);
            });

            // Set total price
            totalPriceCell.textContent = data.reduce((acc, curr) => acc + Number(curr.event_price), 0);
        })
        .catch(error => console.error('Error fetching data:', error));
});