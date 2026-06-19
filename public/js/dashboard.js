document.addEventListener('DOMContentLoaded', () => {

    
    const addBatchForm = document.getElementById('add-batch-form');
    if (addBatchForm) {
        addBatchForm.addEventListener('submit', async (e) => {
            e.preventDefault(); 

            const formData = new FormData(addBatchForm);

            try {
                const response = await fetch('/stock/add', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (response.ok) {
                    alert('Succès : ' + result.message);
                    addBatchForm.reset();
                    if (document.getElementById('batches-table-body')) {
                        loadDashboardData('all');
                    }
                } else {
                    alert('Erreur : ' + result.error);
                }
            } catch (error) {
                console.error('Erreur lors de l\'ajout :', error);
            }
        });
    }
    const tableBody = document.getElementById('batches-table-body');
    const badgeCounter = document.getElementById('next-month-counter');

    async function loadDashboardData(criteria = 'all') {
        if (!tableBody) return; 

        try {
            const response = await fetch(`/api/v1/batches?criteria=${criteria}`);
            const result = await response.json();

            if (!response.ok) {
                console.error(result.error);
                return;
            }
            if (badgeCounter) {
                badgeCounter.textContent = result.stats.périssent_le_mois_prochain;
            }
            tableBody.innerHTML = ''; 

            result.batches.forEach(batch => {
                const tr = document.createElement('tr');
                tr.setAttribute('id', `batch-row-${batch.id}`);


});