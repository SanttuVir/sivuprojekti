document.addEventListener("DOMContentLoaded", function () {
    // Replace with the correct path to your Admin.php endpoint
    fetch("http://localhost/sivu/Tilaa/Admin.php") 
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.Kontsa__content');
            container.innerHTML = '<h1>Alkuruoat</h1>'; // Clear default content and add heading

            // Check if data is an array (in case there is no data, prevent errors)
            if (Array.isArray(data)) {
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
            console.error('Virhe haettaessa tietoja:', error);
            const container = document.querySelector('.Kontsa__content');
            container.innerHTML = '<p>Virhe haettaessa tietoja.</p>';
        });
});
