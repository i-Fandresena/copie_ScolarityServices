<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('css/releve.css') }}">
    <title>Relevé de Note</title>
</head>
<body>
<div class="content">
    <div class="header">
        REPOBLIKAN’I MADAGASIKARA <br>
        Fitiavana – Tanindrazana - Fandrosoana <br>
        ----------------------- <br>
        MINISTERE DE L’ENSEIGNEMENT SUPERIEUR <br>
        ET DE LA RECHERCHE SCIENTIFIQUE <br>
        ------------------------- <br>
        UNIVERSITE DE FIANARANTSOA <br>
        ECOLE NORMALE SUPERIEURE <br>
        --------------- <br>
        <h4>RELEVE DE NOTES</h4> <br>
    </div>
    <div class="info">
        <div class="left">
            N° {{ sprintf('%03d', strval($numReleve)) }}/RN/SED/ENS/Sco. <br>
            <span class="bold unlined">NOM ET PRENOMS</span> : {{ $nom }} {{ $prenom }} <br>
            <span class="bold unlined">NE(E) LE</span> : {{ $dateNaissance }} à {{ $lieuNaissance }} <br>
            <span class="bold unlined">MENTION</span> : <span class="bold">Sciences de l'Education</span> <br>
            <span class="bold unlined">PARCOURS</span> : <span class="bold">{{ $parcours }}</span>
        </div>
        <div class="right">
            <div class="text">
                <span class="text-left bold unlined">NIVEAU</span> <span class="text-right">: {{ $niveau }}</span><br>
            </div>
            <div class="text">
                <span class="text-left bold unlined">N° D'INSCRIPTION</span> <span class="text-right">: {{ $numInscrit }} </span><br>
            </div>
            <div class="text">
                <span class="text-left bold unlined ">ANNEE UNIVERSITAIRE</span> <span class="text-right">: {{ $annee }} </span> <br>
            </div>
        </div>
    </div>
    <div class="table-view">
        <table>
            <thead>
            <tr>
                <th class="matiere">MATIERES ENSEIGNEES</th>
                <th class="center">COEFF.</th>
                <th class="center">NOTES DEFINITIVES</th>
                <th class="center">NOTES MAX.</th>
            </tr>
            </thead>
            <tbody>
             @foreach(json_decode($releves) as $releve)
                 <tr>
                     <td class="matiere"> {{$releve->matiere}} </td>
                     <td class="center"> {{ $releve->poids }} </td>
                     <td class="center">{{ $releve->note }}</td>
                     <td class="center">{{ $releve->max  }}</td>
                 </tr>
             @endforeach

            <!--comment-->

            <tr>
                <td class="center bold">TOTAL</td>
                <td class="center bold"> {{ $sumPoids }}</td>
                <td class="center bold"> {{ $sumNote }} </td>
                <td class="center">{{ $sumNoteMax }}</td>
            </tr>
            <tr>
                <td colspan="2" class="center bold">
                    MOYENNE
                </td>
                <td class="center bold">{{ $moyenne }}</td>
                <td class="center">/20</td>
            </tr>
            <tr>
                <td colspan="2" class="center bold">
                    MENTION
                </td>
                <td colspan="2" class="center bold">
                    {{ $mention }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center bold">
                    DECISION
                </td>
                <td colspan="2" class="center bold">
                    {{ $decision }}
                </td>
            </tr>
            </tbody>
        </table>
        <div class="end">
            <div class="first">
                Fianarantsoa, le {{ $dateNow }} <br>
                Le Chef de service de la scolarité
            </div>
            <div class="second">
                RABEMIAFARA Herimandimby
            </div>
        </div>
    </div>
</div>
</body>
</html>
