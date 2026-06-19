<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PharmaFEFO</title>
    <style>
        :root {
            --bg: #f0f7ff;
            --card-bg: #ffffff;
            --primary-blue: #0ea5e9;
            --accent-chibi: #e0f2fe;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --error-bg: #fff5f5;
            --error-text: #f03e3e;
            --error-border: #ffe3e3;
        }
        
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        
        .login-container { background: var(--card-bg); padding: 40px 35px; border-radius: 20px; border: 1px solid var(--border-color); box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.05); width: 360px; box-sizing: border-box; }
        
        .brand-header { text-align: center; margin-bottom: 30px; }
        .brand-header h1 { font-size: 26px; color: var(--primary-blue); margin: 0 0 8px 0; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .brand-header h1 span { font-weight: 400; color: #cbd5e1; }
        .brand-header p { font-size: 14px; color: var(--text-muted); margin: 0; font-weight: 500; }
        
        .error-msg { background: var(--error-bg); color: var(--error-text); border: 1px solid var(--error-border); padding: 12px 15px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        
        .form-group { margin-bottom: 20px; display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: var(--text-muted); letter-spacing: 0.3px; }
        .form-group input { padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; outline: none; transition: 0.2s; background: #fdfeff; color: var(--text-dark); }
        .form-group input::placeholder { color: #cbd5e1; }
        .form-group input:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); background: white; }
        
        .btn-submit { width: 100%; background: var(--primary-blue); color: white; border: none; padding: 13px; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: 700; transition: 0.2s; margin-top: 10px; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15); }
        .btn-submit:hover { background: #0c91cc; box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25); }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="brand-header">
            <h1>PharmaFEFO</h1>
            <p>Gestion Intelligente des Stocks</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                ️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=login" method="POST">
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" placeholder="ex: admin@pharma.com" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>

</body>
</html>