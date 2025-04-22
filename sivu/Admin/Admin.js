document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('alkuruokaForm');
    const button = document.getElementById('submitButton');
    const nameInput = document.getElementById('name');
    const tietoaInput = document.getElementById('tietoa');
    const hintaInput = document.getElementById('hinta');
    const container = document.getElementById('alkuruokaContainer');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = nameInput.value.trim();
        const tietoa = tietoaInput.value.trim();
        const hinta = hintaInput.value.trim();

        if (!name || !tietoa || !hinta) {
            alert('Täytä kaikki kentät.');
            return;
        }

        const formData = new FormData();
        formData.append('name', name);
        formData.append('tietoa', tietoa);
        formData.append('hinta', hinta);

        const isEdit = button.textContent === 'Muokkaa';
        if (isEdit) {
            const id = button.getAttribute('data-id');
            formData.append('id', id); // Include the id for updating
        }

        // Send data to the backend (Admin.php)
        fetch('Admin.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                form.reset();
                button.textContent = 'Lisää'; // Reset button to "Add"
                button.removeAttribute('data-id');
                loadAlkuruoka(); // Reload the menu list after success
            }
        })
        .catch(err => {
            console.error('Virhe:', err);
            alert('Tietojen lähetyksessä tapahtui virhe.');
        });
    });

    // Load the Alkuruoka (menu) items from the database
    function loadAlkuruoka() {
        fetch('Admin.php')
        .then(res => res.json())
        .then(items => {
            container.innerHTML = "<h2>Alkuruoka</h2>"; // Clear the container and add the header
            items.forEach(item => {
                const el = document.createElement('div');
                el.className = 'alkuruoka-item';
                el.innerHTML = `
                    <p><strong>${item.name}</strong> - <em>${item.hinta} €</em></p>
                    <p>${item.tietoa}</p>
                    <button onclick="editAlkuruoka(${item.id}, '${item.name}', '${item.tietoa}', '${item.hinta}')">Muokkaa</button>
                    <button onclick="deleteAlkuruoka(${item.id})" style="color:red;">Poista</button>
                `;
                container.appendChild(el);
            });
        })
        .catch(err => console.error('Virhe alkuruokien latauksessa:', err));
    }

    // Handle editing an Alkuruoka (menu item)
    window.editAlkuruoka = function(id, name, tietoa, hinta) {
        nameInput.value = name;
        tietoaInput.value = tietoa;
        hintaInput.value = hinta;
        button.textContent = 'Muokkaa'; // Change button to "Edit"
        button.setAttribute('data-id', id); // Store the id for the item being edited
    }

    // Handle deleting an Alkuruoka (menu item)
    window.deleteAlkuruoka = function(id) {
        if (confirm('Haluatko varmasti poistaa tämän tuotteen?')) {
            fetch(`Admin.php?id=${id}`, {
                method: 'DELETE' // Send DELETE request with the item ID
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') loadAlkuruoka(); // Reload items after deletion
            })
            .catch(err => {
                console.error('Virhe poistossa:', err);
                alert('Tuotteen poistaminen epäonnistui.');
            });
        }
    }

    loadAlkuruoka(); // Initial load of Alkuruoka items
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('paaruokaForm');
    const button = document.getElementById('submitButton');
    const nameInput = document.getElementById('name');
    const tietoaInput = document.getElementById('tietoa');
    const hintaInput = document.getElementById('hinta');
    const container = document.getElementById('paaruokaContainer');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = nameInput.value.trim();
        const tietoa = tietoaInput.value.trim();
        const hinta = hintaInput.value.trim();

        if (!name || !tietoa || !hinta) {
            alert('Täytä kaikki kentät.');
            return;
        }

        const formData = new FormData();
        formData.append('name', name);
        formData.append('tietoa', tietoa);
        formData.append('hinta', hinta);

        const isEdit = button.textContent === 'Muokkaa';
        if (isEdit) {
            const id = button.getAttribute('data-id');
            formData.append('id', id); // Include the id for updating
        }

        // Send data to the backend (Admin2.php)
        fetch('Admin2.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                form.reset();
                button.textContent = 'Lisää'; // Reset button to "Add"
                button.removeAttribute('data-id');
                loadPaaruoka(); // Reload the menu list after success
            }
        })
        .catch(err => {
            console.error('Virhe:', err);
            alert('Tietojen lähetyksessä tapahtui virhe.');
        });
    });

    // Load the Paaruoka (menu) items from the database
    function loadPaaruoka() {
        fetch('Admin2.php')
        .then(res => res.json())
        .then(items => {
            container.innerHTML = "<h2>Paaruoka</h2>"; // Clear the container and add the header
            items.forEach(item => {
                const el = document.createElement('div');
                el.className = 'paaruoka-item';
                el.innerHTML = `
                    <p><strong>${item.name}</strong> - <em>${item.hinta} €</em></p>
                    <p>${item.tietoa}</p>
                    <button onclick="editPaaruoka(${item.id}, '${item.name}', '${item.tietoa}', '${item.hinta}')">Muokkaa</button>
                    <button onclick="deletePaaruoka(${item.id})" style="color:red;">Poista</button>
                `;
                container.appendChild(el);
            });
        })
        .catch(err => console.error('Virhe paaruokien latauksessa:', err));
    }

    // Handle editing a Paaruoka (menu item)
    window.editPaaruoka = function(id, name, tietoa, hinta) {
        nameInput.value = name;
        tietoaInput.value = tietoa;
        hintaInput.value = hinta;
        button.textContent = 'Muokkaa'; // Change button to "Edit"
        button.setAttribute('data-id', id); // Store the id for the item being edited
    }

    // Handle deleting a Paaruoka (menu item)
    window.deletePaaruoka = function(id) {
        if (confirm('Haluatko varmasti poistaa tämän tuotteen?')) {
            fetch(`Admin2.php?id=${id}`, {
                method: 'DELETE' // Send DELETE request with the item ID
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') loadPaaruoka(); // Reload items after deletion
            })
            .catch(err => {
                console.error('Virhe poistossa:', err);
                alert('Tuotteen poistaminen epäonnistui.');
            });
        }
    }

    loadPaaruoka(); // Initial load of Paaruoka items
});

