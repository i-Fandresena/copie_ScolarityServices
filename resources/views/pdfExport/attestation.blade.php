<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Attestation</title>
    <link rel="stylesheet" href="{{ public_path('css/attestation.css') }}">
</head>
<style>
    body, html {

    }
</style>

<body>
<div class="bg">
    <img src="{{ $logo }}" style="position:absolute" alt="">
</div>
<div class="icon">
    <div class="logo_ens">
        <img src="{{ public_path('/images/ens.png') }}" alt="teste" style="height: 115px;">
    </div>

    <div class="univ_fianar">
        <p>MINISTERE DE L’ENSEIGNEMENT SUPERIEUR <br>ET DE LA RECHERCHE SCIENTIFIQUE <br>UNIVERSITE DE FIANARANTSOA <br>
            <span>--------------------0--------------------</span><br>ECOLE NORMALE SUPERIEURE</p>
    </div>

    <div class="logo_uf">
        <img src="{{ public_path('/images/uf.png') }}" style="height: 91px; width: 73px;">
    </div>
</div>
<div class="numero bg-red">
    <span>N°{{ sprintf('%03d', strval($numeroAttestation)) }}/ENS/UF/{{ $annee }}</span>
</div>
<div class="big_title">
    <span>ATTESTATION</span>
</div>

<div class="le_Dr">
    <span>Le Directeur de l’Ecole Normale Supérieure soussigné, atteste que : </span>
</div>

<div class="mr_mme_mlle">
    <span>Mr/Mme/Mlle :</span>
</div>
<div class="nom">
    <span>{{ $nom }} {{ $prenom }}</span>
</div>

<div class="birth">
    <span>Né(e) le     :</span>
</div>

<div class="date_naissance">
    <span> {{ $dateNaissance }} à {{ $lieuNaissance }}</span>
</div>

<div class="cdt">
    <span>- Remplit les conditions règlements exigées,</span>
</div>

<div class="after_cdt">
    <span>- a subi avec succès les épreuves prescrites en vue de l’obtention du</span>
</div>

<div class="master_one">
    <span>MASTER ONE</span>
</div>

<div class="domaine">
    <span>Domaine :</span>
</div>
<div class="parcours">
    <span> Sciences de l’Education</span>
</div>

<div class="annee_univers">
    <span>Année Universitaire :</span>
</div>
<div class="num_inscription">
    <span> {{ $annee }} sous le Numéro d’inscription {{ $numInscrit }}</span>
</div>

<div class="fait_fianar">
    <span>Fianarantsoa, {{ $dateNow }}</span>
</div>

<div class="nom_dr">
    <span>LE DIRECTEUR DE L’ENS</span>
</div>

<div class="dernier_text">
    <div class="avis">
        <span>AVIS TRES IMPORTANT</span>
    </div>

    <div class="texte">
                    <span>En application des instructions ministériels, il interdit de
                    délivrer une deuxième attestation. <br>
                    L’intéressé ne devra en aucun cas se dessaisir de la présente attestation qui devra être restituée lors de la remise du diplôme définitif. <br>
                    Pour justifier de son grade de candidat doit établir des copies sur papier libre ou photocopier et les faire certifier conformes à l’origine par les autorités compétentes.
                    </span>
    </div>
</div>
</body>
</html>
