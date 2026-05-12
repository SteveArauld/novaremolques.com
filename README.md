# Nova Remolques

Site web e-commerce pour Nova Remolques, spécialisé dans la vente de remorques et équipements associés.

## 🚀 Description

Nova Remolques est une application web Laravel 12 avec interface multilingue permettant aux clients de :
- Parcourir un catalogue de produits (remorques)
- Faire des demandes d'information sur les produits
- Consulter les pages légales et informatives
- Bénéficier d'une interface responsive et moderne

## 🛠️ Stack Technique

### Backend
- **PHP 8.2+**
- **Laravel 12.0** - Framework PHP
- **SQLite** - Base de données
- **Spatie Laravel Translatable** - Gestion multilingue

### Frontend
- **TailwindCSS 4.0** - Framework CSS
- **Vite 7.0** - Build tool
- **Axios** - Client HTTP

### Développement
- **Composer** - Gestionnaire de dépendances PHP
- **PHPUnit** - Tests unitaires
- **Laravel Pint** - Formattage de code

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm/pnpm
- SQLite

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone [repository-url]
cd novaremolques
```

### 2. Installation automatique (recommandé)
```bash
composer run setup
```

Cette commande exécute :
- Installation des dépendances PHP
- Configuration du fichier `.env`
- Génération de la clé d'application
- Migration de la base de données
- Installation des dépendances Node
- Build des assets

### 3. Installation manuelle
```bash
# Installer les dépendances PHP
composer install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Migrer la base de données
php artisan migrate

# Installer les dépendances frontend
npm install
npm run build
```

## 🗄️ Structure de la Base de Données

### Tables principales
- **products** - Catalogue des produits/remorques
- **categories** - Catégories de produits
- **category_product** - Relation many-to-many produits-catégories
- **product_images** - Images des produits
- **orders** - Commandes clients
- **users** - Utilisateurs (tables Laravel par défaut)

## 🌐 Multilinguisme

L'application supporte 5 langues :
- Espagnol (ES) - Langue par défaut
- Français (FR)
- Italien (IT)
- Anglais (EN)
- Portugais (PT)

### Changement de langue
Les utilisateurs peuvent changer de langue via l'URL : `/lang/{locale}`

## 📁 Structure du Projet

```
novaremolques/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php      # Gestion des pages front
│   │   └── CheckoutController.php   # Gestion des commandes
│   └── Models/                      # Modèles Eloquent
├── config/                          # Configuration Laravel
├── database/
│   ├── migrations/                  # Migrations de base de données
│   └── seeders/                     # Données de test
├── resources/
│   ├── views/
│   │   └── front/                   # Templates Blade
│   └── lang/                        # Fichiers de traduction
├── routes/
│   └── web.php                      # Routes web
├── public/                          # Assets accessibles publiquement
└── storage/                         # Stockage des fichiers
```

## 🛣️ Routes Principales

### Pages publiques
- `/` - Page d'accueil
- `/product/{slug}` - Détail d'un produit
- `/product-category/{category}` - Liste par catégorie
- `/negozio` - Boutique
- `/chi-siamo` - À propos
- `/contatto` - Contact
- `/domande-frequenti-faq` - FAQ

### Pages légales
- `/menzioni-legali` - Mentions légales
- `/informativa-sulla-privacy` - Politique de confidentialité
- `/informativa-sulla-cookie` - Politique cookies
- `/condizioni-generali-di-vendita-cgv` - CGV
- `/politica-di-consegna` - Politique de livraison
- `/politica-di-reso-e-rimborso` - Politique de retour
- `/politica-di-pagamento` - Politique de paiement

### E-commerce
- `/cart` - Panier
- `/checkout` - Commande
- `/checkout/process` - Traitement commande (POST)

## ⚙️ Configuration

### Variables d'environnement importantes

```env
APP_NAME='Nova Remolques'
APP_URL=https://novaremolques.com

# Base de données
DB_CONNECTION=sqlite

# Mail
MAIL_HOST=smtp.hostinger.com
MAIL_USERNAME=contacto@novaremolques.com
MAIL_FROM_ADDRESS=contacto@novaremolques.com

# Emails
ADMIN_EMAIL=contacto@novaremolques.com
SUPPORT_EMAIL=contacto@novaremolques.com
```

## 🚀 Lancement du Serveur de Développement

### Mode développement complet
```bash
composer run dev
```

Lance simultanément :
- Serveur Laravel (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Logs (`php artisan pail`)
- Vite dev server (`npm run dev`)

### Serveur simple
```bash
php artisan serve
npm run dev
```

## 🧪 Tests

### Exécuter les tests
```bash
composer run test
# ou
php artisan test
```

### Formattage du code
```bash
vendor/bin/pint
```

## 📦 Déploiement

### Build pour production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Optimisations
```bash
composer install --optimize-autoloader --no-dev
```

## 🔧 Scripts Composer Disponibles

- `composer run setup` - Installation complète du projet
- `composer run dev` - Serveur de développement complet
- `composer run test` - Exécution des tests

## 📧 Configuration Email

L'application utilise Hostinger pour l'envoi d'emails :
- SMTP : `smtp.hostinger.com:465`
- Encryption : SSL
- Email : `contacto@novaremolques.com`

## 🌍 Fonctionnalités Multilingues

Grâce au package `spatie/laravel-translatable` :
- Traduction des contenus dynamiques
- Support des langues RTL (si nécessaire)
- Changement de langue persistant en session

## 📱 Responsive Design

L'interface est entièrement responsive grâce à TailwindCSS :
- Mobile-first approach
- Design moderne et épuré
- Navigation optimisée pour tous les appareils

## 🔒 Sécurité

- Validation des entrées utilisateur
- Protection CSRF
- Gestion sécurisée des sessions
- Filtrage des inputs

## 📞 Support

Pour toute question ou support technique :
- **Email** : contacto@novaremolques.com
- **Site web** : https://novaremolques.com

---

**Développé avec ❤️ pour Nova Remolques**