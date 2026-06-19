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


});