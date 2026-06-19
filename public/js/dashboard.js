document.addEventListener('DOMContentLoaded', () => {
    let currentFilter = 'all';
    const tableBody = document.getElementById('batches-table-body');
    const badgeCounter = document.getElementById('next-month-counter');

    async function loadDashboardData(criteria = 'all') {
        if (!tableBody) return;
        currentFilter = criteria;

        try {
            const response = await fetch(`index.php?url=api/v1/batches&criteria=${criteria}`);
            const result = await response.json();

            if (!response.ok) return;

            if (badgeCounter && result.stats) {
                badgeCounter.textContent = result.stats.périssent_le_mois_prochain;
            }

            tableBody.innerHTML = '';

            if (result.batches.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center; color: #9ca3af; padding:20px;">Aucun lot disponible.</td></tr>`;
                return;
            }

            result.batches.forEach(batch => {
                const tr = document.createElement('tr');
                if (parseInt(batch.quantite) === 0 || batch.statut === 'EXPIRED') {
                    tr.style.opacity = '0.5';
                    tr.style.backgroundColor = '#f3f4f6';
                }

                tr.innerHTML = `
                    <td style="font-weight:bold;">${batch.medicament_name || 'Inconnu'}</td>
                    <td><code>${batch.numero_lot}</code></td>
                    <td>${batch.quantite} boîtes</td>
                    <td>${batch.date_peremption}</td>
                    <td><span class="badge ${batch.statut}">${batch.statut}</span></td>
                `;
                tableBody.appendChild(tr);
            });
        } catch (error) {
            console.error('Erreur Fetch:', error);
        }
    }

    const filterAllBtn = document.getElementById('filter-all-btn');
    const filterCriticalBtn = document.getElementById('filter-critical-btn');
    if (filterAllBtn) filterAllBtn.addEventListener('click', () => loadDashboardData('all'));
    if (filterCriticalBtn) filterCriticalBtn.addEventListener('click', () => loadDashboardData('critical'));

    loadDashboardData('all');
});