document.addEventListener('DOMContentLoaded', () => {

    let currentFilter = 'all'; 

    const addBatchForm = document.getElementById('add-batch-form');
    if (addBatchForm) {
        addBatchForm.addEventListener('submit', async (e) => {
            e.preventDefault(); 
            const formData = new FormData(addBatchForm);

            try {
                const response = await fetch('index.php?url=stock/add', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (response.ok) {
                    alert('Succès : ' + result.message);
                    addBatchForm.reset();
                    loadDashboardData(currentFilter); 
                } else {
                    alert('Erreur : ' + (result.error || 'Une erreur est survenue'));
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
        currentFilter = criteria; 

        try {
            const response = await fetch(`index.php?url=api/v1/batches&criteria=${criteria}`);
            const result = await response.json();

            if (!response.ok) {
                console.error(result.error);
                return;
            }

            if (badgeCounter && result.stats) {
                badgeCounter.textContent = result.stats.périssent_le_mois_prochain;
            }

            tableBody.innerHTML = ''; 

            if (result.batches.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding: 20px; color: #9ca3af;">Aucun lot trouvé.</td></tr>`;
                return;
            }

            result.batches.forEach(batch => {
                const tr = document.createElement('tr');
                tr.setAttribute('id', `batch-row-${batch.id}`);
                
                if (parseInt(batch.quantity) === 0 || batch.status === 'EXPIRED') {
                    tr.style.opacity = '0.5';
                    tr.style.backgroundColor = '#f3f4f6';
                }

                tr.innerHTML = `
                    <td style="padding: 10px; font-weight: bold;">${batch.medicament_name || 'Inconnu'}</td>
                    <td style="padding: 10px;"><code>${batch.num_lot}</code></td>
                    <td style="padding: 10px;" id="qty-text-${batch.id}">${batch.quantity} boîtes</td>
                    <td style="padding: 10px;">${batch.date_peremption}</td>
                    <td style="padding: 10px;"><span class="badge ${batch.status}">${batch.status}</span></td>
                    <td style="padding: 10px;">
                        <button class="btn-checkout" data-med-id="${batch.medicament_id}" style="background: #3b82f6; color:white; border:none; padding: 4px 8px; border-radius:4px; cursor:pointer;">Délivrer 1 boîte</button>
                        <button class="btn-destroy" data-batch-id="${batch.id}" style="background: #ef4444; color:white; border:none; padding: 4px 8px; border-radius:4px; cursor:pointer; margin-left:5px;">À détruire</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

        } catch (error) {
            console.error('Erreur Fetch Dashboard:', error);
        }
    }

    const filterAllBtn = document.getElementById('filter-all-btn');
    const filterCriticalBtn = document.getElementById('filter-critical-btn');

    if (filterAllBtn) filterAllBtn.addEventListener('click', () => loadDashboardData('all'));
    if (filterCriticalBtn) filterCriticalBtn.addEventListener('click', () => loadDashboardData('critical'));

    loadDashboardData('all');

    if (tableBody) {
        tableBody.addEventListener('click', async (e) => {
            
            if (e.target.classList.contains('btn-checkout')) {
                const medId = e.target.getAttribute('data-med-id');

                try {
                    const response = await fetch('index.php?url=api/v1/batches/checkout', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ medicament_id: medId })
                    });
                    const result = await response.json();

                    if (response.ok) {
                        loadDashboardData(currentFilter); 
                    } else {
                        alert(result.error);
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            if (e.target.classList.contains('btn-destroy')) {
                const batchId = e.target.getAttribute('data-batch-id');

                if (confirm("Voulez-vous vraiment détruire ce lot ?")) {
                    try {
                        const response = await fetch('index.php?url=api/v1/batches/destroy', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ batch_id: batchId })
                        });
                        const result = await response.json();

                        if (response.ok) {
                            loadDashboardData(currentFilter); 
                        } else {
                            alert(result.error);
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            }
        });
    }
});