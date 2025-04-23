document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector('.Kontsa__content');
    
    // Fetch data from PHP endpoint
    fetch("http://localhost/sivu/Admin/viinit.php")
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data'); 
            }
            return response.json();
        })
        .then(data => {
            container.innerHTML = '<h1>Viinit</h1>'; // Clear default content and add heading

            // Check if data is an array (to handle case where no data is returned)
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="alkuruoka-item">
                            <h3>${item.name}</h3>
                            <h2>${item.tietoa}</h2>
                            <h4>${item.hinta} €</h4> <!-- Display the price -->
                        </div>
                    `;
                });
            } else {
                container.innerHTML += '<p>No data available.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            container.innerHTML = '<p>Virhe haettaessa tietoja.</p>';
        });
});
