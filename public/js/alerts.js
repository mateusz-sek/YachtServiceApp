document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('success-alert');

    if (alert) {
        // 1. POJAWIENIE SIĘ: Usuń klasę 'translate-x-full', aby wsunąć alert
        setTimeout(() => {
            alert.classList.remove('translate-x-full');
        }, 100); // Małe opóźnienie, aby zapewnić, że CSS załaduje stan początkowy

        // 2. ZNIKANIE: Dodaj klasę 'translate-x-full' po 4 sekundach, aby alert się wysunął
        setTimeout(() => {
            alert.classList.add('translate-x-full');
            
            // 3. USUNIĘCIE: Całkowite usunięcie elementu po zakończeniu animacji
            setTimeout(() => {
                alert.remove();
            }, 500); // Czas musi być równy duration-500 z klasy Tailwind
            
        }, 4000); // 4000 ms = 4 sekundy, po których alert zacznie znikać
    }
});


