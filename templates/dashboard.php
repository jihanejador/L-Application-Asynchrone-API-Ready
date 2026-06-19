<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Dashboard</title>
    <style>
        :root {
            --bg: #f0f7ff;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --accent-chibi: #e0f2fe;
            --text-dark: #334155;
            --text-muted: #64748b;
            --primary-blue: #0284c7;
            --border-color: #e2e8f0;
            --success: #10b981;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: var(--bg); color: var(--text-dark); display: flex; height: 100vh; overflow: hidden; }
        
        .sidebar { width: 260px; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); padding: 25px 20px; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; }
        .sidebar h1 { font-size: 22px; margin: 0 0 30px 0; display: flex; align-items: center; gap: 10px; color: var(--primary-blue); font-weight: 700; }
        .user-info { background: var(--bg); border: 1px solid var(--border-color); padding: 15px; border-radius: 12px; margin-bottom: 20px; }
        .user-info strong { color: var(--primary-blue); display: block; font-size: 15px; }
        .user-info span { display: block; color: var(--text-muted); font-size: 11px; text-transform: uppercase; margin-top: 5px; font-weight: 600; }
        
        .sidebar-menu { display: flex; flex-direction: column; gap: 10px; }
        .menu-link { display: flex; align-items: center; gap: 10px; padding: 12px; color: var(--text-dark); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; transition: 0.2s; }
        .menu-link:hover { background: var(--accent-chibi); color: var(--primary-blue); }
        .menu-link.active { background: var(--primary-blue); color: white; }

        .btn-logout { background: #fef2f2; color: #ef4444; text-decoration: none; text-align: center; padding: 12px; border-radius: 8px; font-weight: bold; transition: 0.2s; display: block; border: 1px solid #fee2e2; }
        .btn-logout:hover { background: #fee2e2; }

        .main-content { flex: 1; padding: 40px; overflow-y: auto; box-sizing: border-box; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .top-bar h2 { margin: 0; font-size: 26px; color: #1e293b; font-weight: 700; }
        
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--border-color); flex: 1; padding: 22px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; }
        .stat-card h3 { margin: 0; font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card .num { font-size: 20px; font-weight: 700; color: var(--text-dark); margin-top: 5px; }
        .counter-badge { background: #fff1f2; color: #f43f5e; font-size: 26px; font-weight: bold; padding: 10px 18px; border-radius: 12px; border: 1px solid #ffe4e6; }

        .filters { margin-bottom: 25px; display: flex; gap: 10px; background: white; padding: 6px; border-radius: 10px; border: 1px solid var(--border-color); width: max-content; }
        .btn { border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: 0.2s; background: transparent; color: var(--text-muted); }
        .btn:hover { background: var(--bg); color: var(--text-dark); }
        .btn.active { background: var(--accent-chibi); color: var(--primary-blue); }
        .btn-critical-style { color: #b45309; }
        .btn-critical-style:hover { background: #fef3c7; }

        .table-container { background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 16px 24px; border-bottom: 1px solid var(--border-color); }
        th { background: #f8fafc; font-weight: 600; color: var(--text-muted); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #fdfeff; }

        .badge { padding: 6px 14px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge.ACTIF { background: #e6fcf5; color: #0ca678; }
        .badge.EXPIRED { background: #fff5f5; color: #f03e3e; }
        .badge.EXHAUSTED { background: #f1f3f5; color: #495057; }

        .form-section { background: var(--card-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-color); }
        .form-section h3 { margin: 0 0 25px 0; font-size: 18px; color: #1e293b; font-weight: 700; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: var(--text-muted); }
        .form-group input { padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; transition: 0.2s; background: #fdfeff; }
        .form-group input:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1); background: white; }
        
        .btn-submit { background: var(--primary-blue); color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.2s; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15); }
        .btn-submit:hover { background: #0274a9; box-shadow: 0 4px 16px rgba(2, 132, 199, 0.25); }
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
            <div class="sidebar-menu">
                <a href="index.php" class="menu-link active">📊 Stock Dashboard</a>
                <?php if (strtolower($user['role']) === 'admin'): ?>
                    <a href="index.php?url=reports" class="menu-link">🛡️ Rapport Financier</a>
                <?php endif; ?>
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
            <button id="filter-all-btn" class="btn active">Tous les lots</button>
            <button id="filter-critical-btn" class="btn btn-critical-style">🚨 Lots Critiques</button>
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