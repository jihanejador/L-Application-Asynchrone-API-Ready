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
                if (batch.quantity == 0 || batch.status === 'EXPIRED') {
                    tr.style.opacity = '0.5';
                    tr.style.backgroundColor = '#f3f4f6';
                }
                tr.innerHTML = `
                    <td>${batch.num_lot}</td>
                    <td>${batch.medicament_name}</td>
                    <td id="qty-text-${batch.id}">${batch.quantity}</td>
                    <td>${batch.date_peremption}</td>
                    <td><span class="badge ${batch.status}">${batch.status}</span></td>
                    <td>
                        <button class="btn-checkout" data-med-id="${batch.medicament_id}">Délivrer 1 boîte</button>
                        <button class="btn-destroy" data-batch-id="${batch.id}" style="background: red; color:white;">À détruire</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

        }


});