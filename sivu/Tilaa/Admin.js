    // Kuuntelee lomakkeen lähettämistä
    document.getElementById('alkuruokaForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Estetään lomakkeen oletustoiminto

        const name = document.getElementById('name').value;
        const tietoa = document.getElementById('tietoa').value;

        if (name && tietoa) {
            const formData = new FormData();
            formData.append('name', name);
            formData.append('tietoa', tietoa);

            // Lähetetään tiedot PHP-skriptille
            fetch('Admin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    document.getElementById('alkuruokaForm').reset();
                    loadAlkuruoka(); // Päivitetään lista uusilla tiedoilla
                }
            })
            .catch(error => {
                console.error('Virhe:', error);
                alert('Tietojen lähetyksessä tapahtui virhe.');
            });
        } else {
            alert('Täytä kaikki kentät.');
        }
    });

    // Funktio hakee ja näyttää alkuruoat
    function loadAlkuruoka() {
        fetch('Admin.php')
        .then(response => response.json())
        .then(alkuruoat => {
            const alkuruokaContainer = document.getElementById('alkuruokaContainer');
            alkuruokaContainer.innerHTML = "<h2>Alkuruoka</h2>";

            alkuruoat.forEach(alkuruoka => {
                const alkuruokaElement = document.createElement('div');
                alkuruokaElement.classList.add('alkuruoka-item');
                
                alkuruokaElement.innerHTML = `
                    <p><strong>${alkuruoka.name}</strong></p>
                    <p>${alkuruoka.tietoa}</p>
                `;
                
                alkuruokaContainer.appendChild(alkuruokaElement);
            });
        })
        .catch(error => console.error('Virhe alkuruokien latauksessa:', error));
    }

    // Ladataan alkuruoat sivun latauksen yhteydessä
    document.addEventListener('DOMContentLoaded', loadAlkuruoka);