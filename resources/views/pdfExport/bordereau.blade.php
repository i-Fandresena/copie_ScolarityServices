<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('css/bordereau.css') }}">
    <title>Justificatif de paiement de frais universitaires</title>
</head>
<body>
<div class="content">
    <div class="header">
        <h3>JUSTIFICATIF DE PAIEMENT DE FRAIS UNIVERSITAIRES</h3>
    </div>
    <div class="main">
        <p>
            <span> {{ $nom.' '.$prenom }}</span>
        </p> <br>
        <p>
            <span style="opacity: 0">cccc</span>Nous vous fournissons ci-joint une preuve matérielle de votre paiement de frais
            de formation pour le niveau <span>{{ $niveau }}</span> de l'année universitaire <span>{{ $anneeUnivers }}</span>, enregistré sous le numéro <span>{{ $numInscrit }}</span>. Ce document certifie que vous avez effectué le paiement
            d'un montant total de <span>{{ $montants }}</span> Ariary avec @if($reference2)les références: <span>{{ $reference1 }}</span> du <span>{{ $date1 }}</span> et <span>{{  $reference2 }}</span> du <span>{{ $date2 }}</span>.@else la référence: <span>{{ $reference1 }}</span> du <span>{{ $date1 }}</span> @endif
        </p> <br>
        <p>
            <span style="opacity: 0">cccc</span>Cette preuve peut être utilisée pour votre propre enregistrement ou pour tout autre usage que vous jugerez nécessaire.
        </p>
    </div>
    <div class="cord">
        <p>
            Fianarantsoa le, {{ $date }}<br>
            Responsable <span style="font-weight: bold;">{{ $responsable }}</span>
        </p> <br><br><br><br>
        <p>
            <span style="font-weight: bold;">{{ $nomResponsable }}</span>
        </p>
    </div>
    <div class="foot">
        <p>UNIVERSITE DE FIANARANTSOA</p>
        <p>ECOLE NORMALE SUPERIEURE</p>
    </div>
</div>
</body>
</html>
