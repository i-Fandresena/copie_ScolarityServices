# Scolarity Service

Scolarity Service est une application web de gestion de scolarite developpee avec Laravel. Elle centralise les operations courantes d'un service de scolarite : preselection des candidats, inscription des etudiants, gestion des notes, suivi des droits de paiement, generation de documents administratifs et exports Excel/PDF.

Le projet suit l'organisation MVC de Laravel et utilise Livewire pour les ecrans interactifs qui necessitent des formulaires dynamiques, de l'import Excel ou des actions sans rechargement complet de page.

## Objectif du projet

L'application repond a un besoin metier concret : faciliter le suivi administratif des candidats et etudiants d'un etablissement d'enseignement superieur.

Elle permet notamment de :

- gerer les candidats en preselection pour les niveaux L1, M1, M2 et Master Recherche ;
- convertir des candidats ou dossiers recus en etudiants inscrits ;
- suivre les etudiants de L1, L2, L3, M1, M2 et Master Recherche ;
- enregistrer et consulter les notes par niveau et par matiere ;
- gerer les droits de paiement et les bordereaux ;
- produire des attestations, releves de notes et bordereaux au format PDF ;
- exporter des listes de candidats, etudiants, notes et modeles au format Excel ;
- gerer les utilisateurs, leurs roles et leur statut d'activation.

## Stack technique

- PHP 8.0+
- Laravel 9
- Laravel Fortify pour l'authentification
- Laravel Sanctum
- Livewire 2
- Blade
- Tailwind CSS
- Vite
- MySQL ou MariaDB
- DomPDF pour la generation PDF
- Spatie Simple Excel / OpenSpout pour les exports Excel
- PHPUnit pour les tests

## Architecture

Le projet reprend la structure MVC standard d'une application Laravel.

| Couche | Emplacement | Role |
| --- | --- | --- |
| Models | `app/Models` | Representation des entites metier et acces aux tables via Eloquent |
| Views | `resources/views` | Templates Blade pour l'interface utilisateur et les documents PDF |
| Controllers | `app/Http/Controllers` | Points d'entree HTTP, orchestration des pages et exports |
| Routes | `routes/web.php` | Definition des routes web et des groupes de middlewares |
| Livewire | `app/Http/Livewire` et `resources/views/livewire` | Composants interactifs pour les formulaires, imports, listes et actions metier |
| Database | `database/migrations` et `database/seeders` | Schema de base de donnees et donnees initiales |

Un document plus detaille est disponible dans [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md).

## Fonctionnalites principales

### Authentification et roles

- Connexion utilisateur et connexion administrateur.
- Middleware de controle d'acces pour les comptes actifs, les administrateurs et les utilisateurs non administrateurs.
- Gestion des utilisateurs depuis l'espace administrateur.
- Activation ou desactivation des comptes.

### Preselection et dossiers recus

- Enregistrement des candidats par niveau.
- Gestion des informations personnelles, academiques et administratives.
- Association avec les droits de preselection et les bordereaux.
- Gestion de dossiers incomplets ou recus avant validation definitive.
- Import de donnees depuis des fichiers Excel.

### Inscriptions

- Suivi des etudiants inscrits par niveau.
- Gestion des parcours.
- Suivi du reste a payer et des situations de paiement.
- Archivage des donnees selon l'annee universitaire.

### Notes

- Gestion des notes par niveau.
- Organisation par unites d'enseignement et elements constitutifs.
- Prise en charge des sessions normale et de rattrapage.
- Export des notes au format Excel.

### Documents et exports

- Generation de releves de notes en PDF.
- Generation d'attestations en PDF.
- Generation de bordereaux en PDF.
- Export Excel des candidats, etudiants, notes et modeles.

## Installation locale

### Prerequis

- PHP 8.0.2 ou plus
- Composer
- Node.js et npm
- MySQL ou MariaDB
- Extension PHP `intl`

### Etapes

1. Cloner le depot :

```bash
git clone https://github.com/i-Fandresena/copie_ScolarityServices.git
cd copie_ScolarityServices
```

2. Installer les dependances PHP :

```bash
composer install
```

3. Installer les dependances JavaScript :

```bash
npm install
```

4. Creer le fichier d'environnement :

```bash
cp .env.example .env
```

Sous Windows PowerShell :

```powershell
Copy-Item .env.example .env
```

5. Generer la cle d'application :

```bash
php artisan key:generate
```

6. Configurer la base de donnees dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scolarity_service
DB_USERNAME=root
DB_PASSWORD=
```

7. Executer les migrations et seeders :

```bash
php artisan migrate --seed
```

8. Compiler les assets :

```bash
npm run build
```

Pour le developpement, utiliser plutot :

```bash
npm run dev
```

9. Lancer le serveur Laravel :

```bash
php artisan serve
```

L'application sera disponible par defaut sur :

```text
http://127.0.0.1:8000
```

## Compte de demonstration

Le seeder cree un compte initial :

```text
Email    : admin@admin.com
Password : admin
Role     : Licence
```

Pour un environnement public ou partage, il est recommande de modifier ce mot de passe apres la premiere connexion.

## Tests et qualite

Lancer les tests :

```bash
php artisan test
```

Verifier la configuration Composer :

```bash
composer validate
```

Construire les assets frontend :

```bash
npm run build
```

## Securite et configuration

- Le fichier `.env` ne doit pas etre versionne.
- Les valeurs sensibles doivent rester dans les variables d'environnement.
- Les acces sont controles par les middlewares Laravel et les roles applicatifs.
- Les imports de fichiers passent par les composants Livewire et les validations Laravel.
- Les documents generes utilisent les vues Blade dediees dans `resources/views/pdfExport`.

## Structure du projet

```text
app/
  Http/
    Controllers/      Controleurs HTTP
    Livewire/         Composants interactifs
    Middleware/       Middlewares d'authentification et d'autorisation
  Models/             Modeles Eloquent
database/
  migrations/         Schema de base de donnees
  seeders/            Donnees initiales
resources/
  views/              Vues Blade
  css/                Styles applicatifs
  js/                 JavaScript applicatif
routes/
  web.php             Routes web principales
public/
  css/                Feuilles de style publiques
  images/             Images utilisees par l'application et les PDF
tests/
  Feature/            Tests fonctionnels
  Unit/               Tests unitaires
```

## Points d'amelioration identifies

Le projet est fonctionnel et presente une architecture Laravel MVC claire. Certaines zones peuvent encore etre ameliorees dans une logique de maintenance long terme :

- extraire une partie de la logique metier des composants Livewire volumineux vers des services dedies ;
- ajouter davantage de tests fonctionnels sur les parcours critiques ;
- renforcer la validation des imports Excel avec des objets de requete ou validateurs specialises ;
- standardiser progressivement les messages utilisateur et l'encodage des textes historiques.

Ces points ne remettent pas en cause l'architecture du projet ; ils constituent une feuille de route naturelle pour faire evoluer l'application vers une base de code plus modulaire.
