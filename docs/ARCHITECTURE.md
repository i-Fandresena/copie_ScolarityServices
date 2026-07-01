# Architecture du projet

Ce document resume l'organisation technique de Scolarity Service afin de faciliter la lecture du depot.

## Vue d'ensemble

Scolarity Service est une application Laravel 9 organisee autour du modele MVC :

- les routes recoivent les requetes HTTP ;
- les controleurs orientent les requetes vers les vues ou les traitements ;
- les modeles Eloquent representent les donnees metier ;
- les vues Blade affichent les pages et les documents PDF ;
- les composants Livewire gerent les interfaces interactives.

Livewire est utilise comme couche de presentation interactive. Il ne remplace pas MVC : il complete les vues Blade pour les ecrans ou l'utilisateur manipule beaucoup de donnees.

## Flux HTTP principal

```text
Navigateur
  -> routes/web.php
  -> middleware auth / role / activation
  -> Controller ou composant Livewire
  -> Model Eloquent
  -> Base de donnees
  -> Vue Blade ou reponse PDF/Excel
```

## Couche Model

Les modeles sont situes dans `app/Models`.

Les principaux groupes sont :

- `Candidats` : candidats en phase de preselection ;
- `Students` : etudiants inscrits ;
- `Notes` : notes par niveau ;
- `Archives` : donnees archivees ;
- `DossierRecus` : dossiers recus avant validation complete ;
- modeles transverses comme `Droit`, `Bordereau`, `Attestation`, `Releve`, `Parcours`, `UniteEnseignement` et `ElementConstitutif`.

Les relations Eloquent sont utilisees pour relier les entites, par exemple un candidat avec son bordereau ou son droit associe.

## Couche Controller

Les controleurs sont situes dans `app/Http/Controllers`.

Exemples :

- `AccueilController` : page d'accueil utilisateur ;
- `InscriptionController` : entree vers le module inscription ;
- `NoteController` : entree vers le module notes ;
- `CertificateController` : entree vers le module certificats ;
- `DossierRecusController` : entree vers le module dossiers recus ;
- `Export/ExporterController` : generation Excel et PDF ;
- `Admin/AdminController` : tableau de bord et gestion des utilisateurs.

## Couche View

Les vues sont situees dans `resources/views`.

Organisation principale :

- `menu/` : pages principales par module ;
- `livewire/` : vues associees aux composants Livewire ;
- `auth/` : vues d'authentification et profil ;
- `admin/` : vues de l'espace administrateur ;
- `pdfExport/` : templates Blade utilises pour les PDF.

## Composants Livewire

Les composants Livewire sont situes dans `app/Http/Livewire`.

Ils gerent les formulaires et listes dynamiques :

- preselection ;
- inscription et listes d'etudiants ;
- gestion des notes ;
- dossiers recus ;
- certificats ;
- exports ;
- gestion de profil.

Certains composants concentrent une logique metier importante. Une evolution naturelle du projet serait d'extraire progressivement cette logique vers des services applicatifs afin de reduire la taille des composants et de faciliter les tests.

## Base de donnees

Les migrations sont dans `database/migrations`.

Elles couvrent notamment :

- utilisateurs et authentification ;
- candidats ;
- etudiants ;
- notes ;
- archives ;
- droits ;
- bordereaux ;
- attestations ;
- releves ;
- parcours et matieres.

Les seeders dans `database/seeders` initialisent :

- un compte utilisateur de demonstration ;
- les droits ;
- les unites d'enseignement ;
- les matieres ;
- les parcours L3.

## Securite applicative

Le projet utilise plusieurs mecanismes Laravel :

- authentification via Fortify ;
- middlewares d'acces (`auth`, `auth.admin`, `admin`, `not.admin`, `activated`) ;
- validation Laravel dans les controleurs et composants Livewire ;
- protection CSRF native Laravel ;
- stockage des secrets dans `.env`, non versionne.

## Exports

Deux types d'exports sont geres :

- PDF avec DomPDF et les vues `resources/views/pdfExport` ;
- Excel avec Spatie Simple Excel / OpenSpout.

Les exports couvrent les candidats, etudiants, notes, attestations, releves et bordereaux.

## Lecture rapide pour evaluation technique

Pour evaluer l'architecture, les fichiers les plus representatifs sont :

- `routes/web.php` pour le routage et les middlewares ;
- `app/Http/Controllers/Export/ExporterController.php` pour les exports ;
- `app/Http/Livewire/Preselection.php` pour un exemple de formulaire metier interactif ;
- `app/Models/Candidats/CandidatL.php` pour un modele Eloquent simple avec relations ;
- `database/migrations` pour le schema ;
- `resources/views/pdfExport` pour les documents generes.
