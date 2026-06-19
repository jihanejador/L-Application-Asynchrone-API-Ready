# 💊 PharmaFEFO - Système de Gestion d'Inventaire Pharmaceutique (Partie 2)

PharmaFEFO est une application web de gestion de stock de médicaments basée sur la règle **FEFO (First Expired, First Out)**. Cette deuxième partie du projet implémente une architecture asynchrone moderne utilisant **PHP (Clean MVC / Services)** pour le Back-end et **JavaScript (Fetch API / ES6)** pour le Front-end, éliminant ainsi les rechargements de page intempestifs.

---

## 🚀 Fonctionnalités Clés (Épics Implémentés)

### 📦 Épic 1 : Réception & Entrées Intelligentes
* **US 1.1 :** Ajout de nouveaux lots via un formulaire asynchrone (`Event.preventDefault()`). Les données sont transmises via `fetch()` au format `FormData`.
* **Sécurité :** La route `/stock/add` est strictement réservée au rôle `PREPARATEUR`.

### 🚨 Épic 2 : Surveillance & Alertes Péremption
* **US 2.1 :** Filtres dynamiques ("Tout", "Alerte Rouge") sur le tableau de bord. Le contrôleur PHP expose un endpoint API JSON (`/api/v1/batches?criteria=critical`) et le DOM est reconstruit dynamiquement en JavaScript.
* **US 2.2 :** Encadré dynamique en haut du dashboard affichant le décompte exact des produits qui périment le mois prochain dès l'accès à l'application.

### 🎯 Épic 3 : Sorties de Stock Intelligentes (Le Cœur FEFO)
* **US 3.1 :** Bouton "Délivrer 1 boîte" qui déclenche une requête asynchrone (`POST/PATCH`) vers `/api/v1/batches/checkout`.
* **Algorithme FEFO :** Le système décrémente automatiquement le lot dont la date de péremption est la plus proche. Si la quantité tombe à `0`, la ligne HTML se grise instantanément.

### 🛡️ Épic 4 : Gestion des Pertes & Retours (Admin)
* **US 4.1 :** Bouton "Périmé / À détruire" permettant au `PHARMACIEN` de passer instantanément le statut d'un lot à `EXPIRED` et sa quantité à `0` sans rafraîchir le navigateur.
* **US 4.2 :** Route sécurisée `/admin/reports` permettant à l' `ADMINISTRATEUR` de visualiser le rapport financier des pertes (strictement interdite aux autres rôles).

---

## 📂 Structure du Projet

```text
pharmafefo/
├── config/
│   ├── database.php          # Connexion PDO (Singleton)
│   └── environment.php       # Variables d'environnement
├── public/
│   ├── css/                  # Feuilles de style
│   ├── js/
│   │   ├── app.js            # Gestion globale (Sécurité, déconnexion)
│   │   └── dashboard.js      # Logique Fetch API & Manipulation du DOM
│   └── index.php             # Routeur Unique (Aiguillage Web et API)
├── src/
│   ├── Controller/
│   │   ├── Web/              # Contrôleurs traditionnels (Retournent du HTML)
│   │   │   ├── AuthController.php
│   │   │   └── AdminController.php
│   │   └── Api/              # Contrôleurs API (Retournent uniquement du JSON)
│   │       ├── ApiDashboardController.php
│   │       └── ApiStockController.php
│   ├── Entity/               # Entités de données
│   ├── Service/              # Logique Métier isolée
│   │   ├── AuthService.php   # Gestion des sessions et vérification stricte des rôles
│   │   └── StockService.php  # Algorithme FEFO et requêtes de stock
│   └── Repository/           # Gestion des requêtes SQL de base
└── templates/                # Squelettes HTML initiaux


realise par : Jihane Jador;