<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Dashboard</title>
    <style>
        :root {
            --primary: #0f172a;
            --accent: #10b981;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #334155;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: var(--bg); color: var(--text); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: var(--primary); color: white; padding: 25px 20px; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; }
        .sidebar h1 { font-size: 20px; margin: 0 0 30px 0; display: flex; align-items: center; gap: 10px; color: var(--accent); }
        .user-info { background: rgba(255,255,255,0.05); padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .user-info span { display: block; color: #94a3b8; font-size: 11px; text-transform: uppercase; margin-top: 4px; }
        .btn-logout { background: #ef4444; color: white; text-decoration: none; text-align: center; padding: 10px; border-radius: 6px; font-weight: bold; transition: 0.2s; display: block; margin-top: auto; }
        .btn-logout:hover { background: #dc2626; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; box-sizing: border-box; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .top-bar h2 { margin: 0; font-size: 24px; color: #1e293b; }
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card); flex: 1; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .stat-card h3 { margin: 0; font-size: 14px; color: #64748b; text-transform: uppercase; }
        .stat-card .num { font-size: 28px; font-weight: bold; color: #0f172a; margin-top: 5px; }
        .counter-badge { background: #fee2e2; color: #ef4444; font-size: 24px; font-weight: bold; padding: 10px 15px; border-radius: 8px; }
        .filters { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn { border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: 0.2s; }
        .btn-all { background: #e2e8f0; color: #475569; }
        .btn-all:hover { background: #cbd5e1; }
        .btn-critical { background: #fef3c7; color: #d97706; }
        .btn-critical:hover { background: #fef08a; }
        .table-container { background: var(--card); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; }
        th { background: #f8fafc; font-weight: 600; color: #64748b; font-size: 13px; text-transform: uppercase; }
        tr:hover { background: #f8fafc; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .badge.ACTIF { background: #d1fae5; color: #065f46; }
        .badge.EXPIRED { background: #fee2e2; color: #991b1b; }
        .badge.EXHAUSTED { background: #f3f4f6; color: #374151; }
        .form-section { background: var(--card); padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .form-section h3 { margin: 0 0 20px 0; font-size: 18px; color: #1e293b; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #64748b; }
        .form-group input { padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; outline: none; transition: 0.2s; }
        .form-group input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
        .btn-submit { background: var(--accent); color: white; padding: 11px 25px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <h1>🏥 PharmaFEFO</h1>
            <div class="user-info">
                <strong><?= htmlspecialchars($user['nom']) ?></strong>
                <span>Rôle: <?= htmlspecialchars($user['role']) ?></span>
            </div>
        </div>
        <a href="index.php?url=logout" class="btn-logout">Déconnexion</a>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2>Tableau de Bord Stock</h2>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div>
                    <h3>Alertes de Péremption</h3>
                    <div class="num">Moins de 30 jours</div>
                </div>
                <div id="next-month-counter" class="counter-badge">0</div>
            </div>
        </div>

        <div class="filters">
            <button id="filter-all-btn" class="btn btn-all">Tous les lots</button>
            <button id="filter-critical-btn" class="btn btn-critical">🚨 Lots Critiques</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Médicament</th><th>N° Lot</th><th>Quantité</th><th>Date Péremption</th><th>Statut</th></tr>
                </thead>
                <tbody id="batches-table-body"></tbody>
            </table>
        </div>
        
        <?php if (in_array(strtolower($user['role']), ['preparateur', 'admin'])): ?>
        <div class="form-section">
            <h3>📦 Ajouter un nouveau lot au stock</h3>
            <form id="add-batch-form">
                <div class="form-grid">
                    <div class="form-group"><label>ID Médicament</label><input type="number" name="medicament_id" required></div>
                    <div class="form-group"><label>Numéro de Lot</label><input type="text" name="numero_lot" required></div>
                    <div class="form-group"><label>Quantité</label><input type="number" name="quantite" required></div>
                    <div class="form-group"><label>Date de Péremption</label><input type="date" name="date_peremption" required></div>
                </div>
                <button type="submit" class="btn btn-submit">Ajouter au Stock</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <script src="js/dashboard.js"></script>
</body>
</html>