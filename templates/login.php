<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - PharmaFEFO</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); width: 320px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #374151; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; background: #10b981; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .error-msg { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="text-align: center; margin-top: 0;">🔐 Connexion</h2>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="index.php?url=login" method="POST">
            <div class="form-group">
                <label>Adresse Email :</label>
                <input type="email" name="email" placeholder="ex: admin@pharma.com" required>
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>
</body>
</html>