document.addEventListener("DOMContentLoaded", function () {
    const villeSelect = document.getElementById('villeSelect');
    const typeSelect = document.getElementById('typeRessource');
    const listRessource = document.getElementById('ressource');
    const valDisplay = document.getElementById("val");
    const qtyInput = document.getElementById('qty');

    /**
     * Charge les ressources en envoyant villeId ET typeId par URL
     */
    function loadResources() {
        const vId = villeSelect.value;
        const tId = typeSelect.value;

        // On n'exécute la requête que si les deux sélections sont faites
        if (vId === "" || tId === "") {
            listRessource.innerHTML = '<option value="">Sélectionner une ressource</option>';
            return;
        }

        const xhr = new XMLHttpRequest();
        // URL avec double paramètre GET
        const url = "ressource/get?villeId=" + encodeURIComponent(vId) + "&typeId=" + encodeURIComponent(tId);
        
        xhr.open('GET', url, true);
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.readyState === 4) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    updateRessourceSelect(data);
                } catch (e) {
                    console.error('Erreur parsing JSON:', e);
                }
            }
        };
        xhr.send(null);
    }

    /**
     * Remplit le select en utilisant une boucle itérative for
     */
    function updateRessourceSelect(ressources) {
        listRessource.innerHTML = "";
        
        // Option par défaut
        const defaultOpt = document.createElement('option');
        defaultOpt.value = "";
        defaultOpt.textContent = "Sélectionner une ressource";
        listRessource.appendChild(defaultOpt);

        // Boucle itérative classique
        for (let i = 0; i < ressources.length; i++) {
            const res = ressources[i];
            const opt = document.createElement('option');
            opt.value = res.id; // Envoi de l'id_ressource
            opt.dataset.prix = res.prixUnitaire;
            opt.textContent = res.nom;
            listRessource.appendChild(opt);
        }
        updateTotal();
    }

    /**
     * Calcul du montant total
     */
    function updateTotal() {
        const selectedOption = listRessource.options[listRessource.selectedIndex];
        const quantite = parseInt(qtyInput.value) || 0;
        
        if (selectedOption && selectedOption.dataset.prix) {
            const prix = parseFloat(selectedOption.dataset.prix);
            const total = (prix * quantite).toFixed(2);
            valDisplay.innerText = total + " $";
        } else {
            valDisplay.innerText = "0.00 $";
        }
    }

    // --- Écouteurs d'événements ---

    // Déclenchement de la requête si l'un des deux change
    villeSelect.addEventListener('change', loadResources);
    typeSelect.addEventListener('change', loadResources);

    // Mise à jour du prix lors du changement de ressource ou de quantité
    listRessource.addEventListener('change', updateTotal);

    document.getElementById('q-').addEventListener('click', function() {
        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            updateTotal();
        }
    });

    document.getElementById('q+').addEventListener('click', function() {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateTotal();
    });
});