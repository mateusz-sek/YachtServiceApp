/* ============================================================
   UNIWERSALNY SYSTEM MODALI
   Wymaga:
   - data-modal="#id-modala"
   - klasy triggera (np. .open-status-modal)
   ============================================================ */

function setupUniversalModal(triggerSelector) {
    document.querySelectorAll(triggerSelector).forEach(btn => {
        btn.addEventListener('click', () => {

            /* ========================
               1. POBIERZ MODAL
               ======================== */
            const modalSelector = btn.dataset.modal;
            if (!modalSelector) {
                console.error('Brak atrybutu data-modal:', btn);
                return;
            }

            const modal = document.querySelector(modalSelector);
            if (!modal) {
                console.error('Nie znaleziono modala:', modalSelector);
                return;
            }

            /* ========================
               2. ELEMENT DO ANIMACJI
               ======================== */
            const modalDialog =
                modal.querySelector('.modal-dialog-content') ||
                modal.querySelector('#delete-modal-content');

            /* ========================
               3. MODAL USUWANIA
               ======================== */
            const itemNameEl = modal.querySelector('.modal-item-name');
            if (itemNameEl && btn.dataset.itemName) {
                itemNameEl.textContent = btn.dataset.itemName;
            }

            const form = modal.querySelector('.modal-form');
            if (form && btn.dataset.formAction) {
                form.action = btn.dataset.formAction;
            }

            /* ========================
               4. MODAL STATUSU PŁATNOŚCI
               ======================== */
            if (btn.dataset.status !== undefined) {
                const shipName = btn.dataset.ship || '';
                const repairId = btn.dataset.id;

                const shipNameEl = modal.querySelector('.modal-ship-name');
                if (shipNameEl) {
                    shipNameEl.textContent = shipName;
                }

                const confirmBtn = modal.querySelector('.modal-confirm-status');
                if (confirmBtn && repairId) {
                    confirmBtn.href = `/repairs/changeStatusPayment/${repairId}`;
                }
            }

            /* ========================
               5. OTWARCIE MODALA
               ======================== */
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                if (modalDialog) {
                    modalDialog.classList.remove('-translate-y-12', 'opacity-0');
                    modalDialog.classList.add('translate-y-0', 'opacity-100');
                }
            }, 10);
        });
    });
}

/* ============================================================
   ZAMYKANIE MODALA (ANULUJ / TŁO / ESC)
   ============================================================ */

function setupModalClosing(modalSelector) {
    const modal = document.querySelector(modalSelector);
    if (!modal) return;

    const modalDialog =
        modal.querySelector('.modal-dialog-content') ||
        modal.querySelector('#delete-modal-content');

    const cancelBtn =
        modal.querySelector('.modal-cancel') ||
        modal.querySelector('.close-modal');

    if (!modalDialog) return;

    const closeModal = () => {
        modalDialog.classList.remove('translate-y-0', 'opacity-100');
        modalDialog.classList.add('-translate-y-12', 'opacity-0');

        modalDialog.addEventListener('transitionend', function handler() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            modalDialog.removeEventListener('transitionend', handler);
        }, { once: true });
    };

    /* Anuluj */
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    /* Klik w tło */
    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });

    /* ESC */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}

/* ============================================================
   INICJALIZACJA
   ============================================================ */


   
/* Zamykanie */
//clients
setupModalClosing('#delete-modal-clients');
setupUniversalModal('.open-modal-clients');

//ships
setupModalClosing('#delete-modal-ships');
setupUniversalModal('.open-modal-ships');


//repairs-status
setupModalClosing('#status-modal-repairs');
setupUniversalModal('.open-modal-repairs');

//repairs-delete
setupModalClosing('#delete-modal-repairs');
setupUniversalModal('.open-modal-destroy-repairs');
