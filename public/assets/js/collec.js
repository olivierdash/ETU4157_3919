document.addEventListener("DOMContentLoaded", function () {
    const villeSelect = document.getElementById('villeSelect');
    const val = document.getElementById("val");
    const listRessource = document.getElementById('ressource');

    function loadAndDisplayResourcesXHR(villeId) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', "ressource/get?villeId=" + villeId, true);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.readyState === 4) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    addMultipleRessources(data);
                    console.log(`${data.length} ressource(s) chargée(s) avec succès`);
                } catch (error) {
                    console.error('Erreur de parsing JSON:', error);
                }
            } else {
                const error = new Error(`Erreur HTTP! Status: ${xhr.status}`);
                console.error(error);
            }
        };
        xhr.onerror = function () {
            const error = new Error('Erreur réseau');
            console.error(error);
        };
        xhr.send(null);
    }

    function addMultipleRessources(ressources) {
        const selectElement = document.getElementById('ressource');
        selectElement.innerHTML = "";
        if (!selectElement) {
            console.error(`Select avec l'id "villeSelect" non trouvé`);
            return;
        }
        const temp = document.createElement('option');
        temp.value = '';
        temp.textContent = "Sélectionner une ressource";
        selectElement.appendChild(temp);
        // Itérer sur chaque ressource et l'ajouter
        for(let i=0; i < ressources.length; i++){
            const ressource = ressources[i];
            console.log(ressource);
            const option = document.createElement('option');
            option.dataset.prix = ressource.prixUnitaire;
            option.value = ressource.id;
            option.textContent = ressource.nom;
            selectElement.appendChild(option);
        }
    }

    function decreaseQty() {
        const qtyInput = document.getElementById('qty');
        const currentValue = parseInt(qtyInput.value);
        
        const selectedOption = listRessource.options[listRessource.selectedIndex];
        const valeur = selectedOption.value;
        if (currentValue > parseInt(qtyInput.min) && valeur !== "") {
            qtyInput.value = currentValue - 1;
            val.innerText = "";
            const temp = qtyInput.value * selectedOption.dataset.prix;
            val.innerText =  temp + "$";
        }
    }
    
    function increaseQty() {
        const qtyInput = document.getElementById('qty');
        const currentValue = parseInt(qtyInput.value);
        const max = qtyInput.max ? parseInt(qtyInput.max) : null;
        const selectedOption = listRessource.options[listRessource.selectedIndex];
        const valeur = selectedOption.value;

        if (valeur !== "") {
            qtyInput.value = currentValue + 1;
            val.innerText = "";
            const temp = Mah.round(qtyInput.value * selectedOption.dataset.prix, 2);
            val.innerText =  temp + "$";
        }
    }
    
    document.getElementById('q-').addEventListener('click', decreaseQty);
    document.getElementById('q+').addEventListener('click', increaseQty);

    villeSelect.addEventListener('change', function () {
        const selectedVilleId = this.value;
        if (selectedVilleId) {
            loadAndDisplayResourcesXHR(selectedVilleId);
        }
    });
});