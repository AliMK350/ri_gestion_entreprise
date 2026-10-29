# Application de gestion d’entreprise (RI)

Application web Laravel destinée à la gestion des ressources humaines, du personnel, des congés, des absences, des clients, des devis, des factures, des reçus et des demandes de documents.

## Prérequis

Avant de commencer, installez les outils suivants :

- **PHP 8.1 ou supérieur**, avec les extensions courantes de Laravel (`openssl`, `pdo_mysql`, `mbstring`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `json`, `gd` ou `dom`)
- **Composer 2**
- **Node.js 18 ou 20** et npm
- **MySQL 8 ou MariaDB 10.5+**
- Git

Sur Windows, Laragon ou XAMPP peut fournir PHP et MySQL. Vérifiez les versions disponibles dans un terminal :

```powershell
php -v
composer --version
node -v
npm -v
mysql --version
```

## 1. Télécharger le projet

```powershell
git clone <URL_DU_DEPOT>
cd ri_gestion_entreprise
```

Remplacez `<URL_DU_DEPOT>` par l’adresse Git du projet.

## 2. Installer les dépendances PHP

```powershell
composer install
```

Pour une installation sans les paquets de développement :

```powershell
composer install --no-dev
```

## 3. Installer les dépendances JavaScript

```powershell
npm install
```

`npm ci` peut être utilisé à la place si les versions du fichier `package-lock.json` doivent être respectées exactement.

## 4. Configurer l’environnement

Copiez le fichier de configuration d’exemple :

```powershell
Copy-Item .env.example .env
```

Sur Linux/macOS, utilisez plutôt :

```bash
cp .env.example .env
```

Générez ensuite la clé de chiffrement Laravel :

```powershell
php artisan key:generate
```

## 5. Créer et configurer la base de données

Ouvrez MySQL, puis créez une base vide. Exemple avec l’utilisateur `root` :

```sql
CREATE DATABASE ri_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Modifiez les variables suivantes dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ri_management
DB_USERNAME=root
DB_PASSWORD=
```

Le mot de passe MySQL doit être saisi après `DB_PASSWORD=` s’il existe.

Ne mettez jamais de vraies clés ou de mots de passe dans les fichiers versionnés. Le fichier `.env` est ignoré par Git.

## 6. Initialiser les tables et les données de départ

```powershell
php artisan migrate
php artisan db:seed
```

Pour recréer entièrement la base locale :

```powershell
php artisan migrate:fresh --seed
```

Attention : cette commande efface toutes les données présentes dans la base locale.

## 7. Préparer les fichiers publics

```powershell
php artisan storage:link
php artisan optimize:clear
```

Si le lien existe déjà, Laravel l’indique sans endommager la configuration existante.

## 8. Compiler les ressources front-end

### Pour le développement

Dans un premier terminal :

```powershell
npm run dev
```

Dans un second terminal :

```powershell
php artisan serve
```

L’application sera accessible sur `http://127.0.0.1:8000`.

### Pour la production locale ou un déploiement

```powershell
npm run build
php artisan optimize
```

Les assets compilés sont placés dans `public/build`.

## Comptes créés par le seeder

Tous les mots de passe sont initialement définis sur `password` :

| Rôle | Adresse e-mail |
|---|---|
| Administrateur | `admin@example.com` |
| Secrétaire | `secretaire@example.com` |
| Employé | `employe@example.com` |
| Gérant | `gerant@example.com` |

Changez immédiatement ces mots de passe sur un environnement partagé ou public.

## Configuration de la messagerie

L’envoi des notifications peut être configuré avec un serveur SMTP dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-adresse@example.com
MAIL_PASSWORD=votre-mot-de-passe-dapplication
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-adresse@example.com
MAIL_FROM_NAME="RH RI Communication"

LEAVE_ADMIN_NOTIFICATION_EMAIL=admin@example.com
LEAVE_EMPLOYEE_NOTIFICATION_EMAIL=employe@example.com
DOCUMENT_REQUEST_ADMIN_NOTIFICATION_EMAIL=admin@example.com
```

Pour Gmail, utilisez un mot de passe d’application plutôt que le mot de passe normal du compte.

Après toute modification de `.env` :

```powershell
php artisan config:clear
```

## Vérifier l’installation

```powershell
php artisan migrate:status
php artisan route:list
php artisan test
```

## Dépannage

### Erreur de clé d’application

```powershell
php artisan key:generate
php artisan config:clear
```

### Erreur de connexion à MySQL

- Vérifiez que MySQL est démarré.
- Vérifiez les paramètres `DB_*` dans `.env`.
- Vérifiez que l’utilisateur MySQL possède les droits sur la base configurée.
- Vérifiez que l’extension PHP `pdo_mysql` est activée.

### Erreur “Vite manifest not found”

En développement, lancez `npm run dev`. Sans processus Vite, lancez `npm run build` puis redémarrez l’application.

### Problèmes de permissions

Assurez-vous que les dossiers `storage` et `bootstrap/cache` existent et que votre compte utilisateur peut les modifier.

### Caches obsolètes

```powershell
php artisan optimize:clear
```

## Technologies principales

- Laravel 10
- PHP 8.1+
- MySQL ou MariaDB
- Laravel Sanctum
- Vite 4
- JavaScript