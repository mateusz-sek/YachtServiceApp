document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------
    // Funkcja uniwersalnego autocomplete
    // ---------------------------
    function setupAutocomplete({ inputId, listId, fetchUrl, formatResult }) {
        const input = document.getElementById(inputId);
        const list = document.getElementById(listId);
        if (!input || !list) return; // jeśli element nie istnieje, kończymy

        // KLASY TAILWIND DLA LISTY
        const TAILWIND_ITEM_CLASS = 'p-2 cursor-pointer text-gray-200 hover:bg-indigo-600 transition duration-150';
        const TAILWIND_ACTIVE_CLASS = 'bg-indigo-700 text-white';

        let timeout = null;
        let selectedIndex = -1;

        input.addEventListener('input', () => {
            const query = input.value.trim();
            list.innerHTML = '';
            selectedIndex = -1;

            if (!query) {
                // JEŚLI PUSTE, UKRYJ LISTĘ (klasa 'hidden' z HTML)
                list.classList.add('hidden'); 
                return;
            }

            // POKAŻ LISTĘ
            list.classList.remove('hidden'); 

            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                try {
                    let url = `${fetchUrl}?q=${encodeURIComponent(query)}`;
                    if (input.dataset.id) {
                        url += `&id=${encodeURIComponent(input.dataset.id)}`;
                    }
                    const res = await fetch(url);
                    const data = await res.json();
                    if (!data || data.length === 0) {
                        list.innerHTML = `<li class="p-2 text-gray-400 italic">Brak wyników</li>`;
                        return;
                    }

                    data.forEach(item => {
                        const li = document.createElement('li');
                        
                        // UŻYCIE KLAS TAILWIND DLA POZYCJI LISTY
                        li.className = TAILWIND_ITEM_CLASS;
                        li.textContent = formatResult(item);

                        li.addEventListener('click', () => {
                            input.value = li.textContent;
                            list.innerHTML = '';
                            // UKRYJ LISTĘ PO KLIKNIĘCIU
                            list.classList.add('hidden');
                        });

                        list.appendChild(li);
                    });
                } catch (err) {
                    console.error(err);
                }
            }, 300);
        });

        // Nawigacja strzałkami i Enter
        input.addEventListener('keydown', (e) => {
            const items = list.querySelectorAll('li');
            if (items.length === 0) return;

            if (e.key === 'ArrowDown') {
                selectedIndex = (selectedIndex + 1) % items.length;
                updateActive(items);
                e.preventDefault();
            }

            if (e.key === 'ArrowUp') {
                selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                updateActive(items);
                e.preventDefault();
            }

            if (e.key === 'Enter' && selectedIndex >= 0) {
                input.value = items[selectedIndex].textContent;
                list.innerHTML = '';
                // UKRYJ LISTĘ PO ZATWIERDZENIU ENTEREM
                list.classList.add('hidden');
                selectedIndex = -1;
                e.preventDefault();
            }
        });

        function updateActive(items) {
            // USUŃ AKTYWNE KLASY ZE WSZYSTKICH ELEMENTÓW
            items.forEach(item => item.classList.remove(TAILWIND_ACTIVE_CLASS));
            
            if (selectedIndex >= 0) {
                const selectedItem = items[selectedIndex];
                // DODAJ KLASĘ AKTYWNĄ I USUŃ KLASY HOVER, ABY NIE KOLIDOWAŁY
                selectedItem.classList.add(TAILWIND_ACTIVE_CLASS);
                selectedItem.classList.remove('hover:bg-indigo-600'); 
                selectedItem.scrollIntoView({ block: 'nearest' });
            }
        }

        // Ukrycie listy po kliknięciu poza input
        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !list.contains(e.target)) {
                list.innerHTML = '';
                selectedIndex = -1;
                // UKRYJ LISTĘ PO KLIKNIĘCIU POZA
                list.classList.add('hidden');
            }
        });
    }

    //clinets------------------------
    setupAutocomplete({
        inputId: 'search_name',
        listId: 'autocomplete-list',
        fetchUrl: '/searchNameClientsJson',
        formatResult: (item) => `${item.first_name} ${item.last_name}`
    });

    setupAutocomplete({
        inputId: 'search_city',
        listId: 'autocomplete-listCity',
        fetchUrl: '/searchNameCityJson',
        formatResult: (item) => `${item.city}`
    });


    //---------------------------
    //ships
    setupAutocomplete({
        inputId: 'search_nameShip',
        listId: 'autocomplete-listShip',
        fetchUrl: '/ships/autocompleteClientsShip',
        formatResult: (item) => `${item.first_name} ${item.last_name}`
    });

    setupAutocomplete({
        inputId: 'int_name_of_ship',
        listId: 'autocompleteshipsClients-list',
        fetchUrl: '/ships/autocompleteNameShip',
        formatResult: (item) => `${item.name}`
    });
    //repair
    
    setupAutocomplete({
        inputId: 'search_nameRepair',
        listId: 'autocomplete-listRepair',
        fetchUrl: '/repairs/autocompleteNameRepairs',
        formatResult: (item) => `${item.first_name} ${item.last_name}`
    });
    setupAutocomplete({
        inputId: 'int_name_of_shipRepair',
        listId: 'autocompleteshipsRepair-list',
        fetchUrl: '/repairs/autocompleteNameShipRepairs',
        formatResult: (item) => `${item.name}`
    });

    //history
    setupAutocomplete({
        inputId: 'search_nameRepairHistory',
        listId: 'autocomplete-listRepairHistory',
        fetchUrl: '/repairs/history/autocompleteNameRepairsHistory',
        formatResult: (item) => `${item.first_name} ${item.last_name}`
    });

    
    setupAutocomplete({
        inputId: 'int_name_of_shipRepairHistory',
        listId: 'autocompleteshipsRepairHistory-list',
        fetchUrl: '/repairs/history/autocompleteNameShipRepairsHistory',
        formatResult: (item) => `${item.name}`
    });


    // ---------------------------
    // Obsługa przycisków "Usuń" z modalem
    // ---------------------------
    document.querySelectorAll('.btn-delete-client').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // zatrzymujemy domyślny link
            const url = this.getAttribute('href'); // pobieramy href przycisku
            const confirmBtn = document.getElementById('confirmDelete');
            if (confirmBtn) confirmBtn.setAttribute('href', url); // przypisujemy do przycisku w modal
            // UWAGA: Ten kod wymaga załadowania Bootstrapa
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });
    });

    // ---------------------------
    // Alert sukcesu
    // ---------------------------
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.classList.add('show');
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 500); // usuń z DOM po animacji
        }, 3000); // alert widoczny 3 sekundy
    }

});