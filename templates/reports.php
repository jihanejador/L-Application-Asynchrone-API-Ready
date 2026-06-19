<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Financier des Pertes</title>
</head>
<body style="background: #f8fafc; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 40px;">
    <div style="max-width: 600px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin: 0 auto;">
        <h2 style="color: #1e293b; margin-top: 0;">🛡️ Zone Admin : Rapport Financier des Pertes</h2>
        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">
        <div style="background: #fee2e2; padding: 20px; border-radius: 8px; color: #991b1b; font-size: 18px; font-weight: 600;">
            Coût total des pertes (Produits Périmés) : <span><?= htmlspecialchars($perte) ?>.00 DH</span>
        </div>
        <p style="margin-top: 25px;"><a href="index.php" style="color: #10b981; text-decoration: none; font-weight: bold;">← Retour au Dashboard</a></p>
    </div>
</body>
</html>