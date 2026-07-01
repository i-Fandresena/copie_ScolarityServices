<?php

namespace Database\Seeders;

use App\Models\ElementConstitutif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matiere = [
            [
                'matiere' => 'Introduction à l’éducation et aux sciences de l’éducation',
                'poids' => 2,
                'idUE' => 1,
            ],
            [
                'matiere' => 'Education et Philosophie',
                'poids' => 2,
                'idUE' => 1,
            ],
            [
                'matiere' => 'Introduction à la psychologie et son application à l’éducation',
                'poids' => 2,
                'idUE' => 2,
            ],
            [
                'matiere' => 'Théories de l’apprentissage',
                'poids' => 2,
                'idUE' => 2,
            ],
            [
                'matiere' => 'Grands courants pédagogiques',
                'poids' => 2,
                'idUE' => 3,
            ],
            [
                'matiere' => 'Différentes approches pédagogiques',
                'poids' => 2,
                'idUE' => 3,
            ],
            [
                'matiere' => 'Approches pédagogiques appliquées à Madagascar',
                'poids' => 2,
                'idUE' => 3,
            ],
            [
                'matiere' => 'Evolution des idées éducative',
                'poids' => 1.5,
                'idUE' => 4,
            ],
            [
                'matiere' => 'Histoire des institutions éducatives',
                'poids' => 1.5,
                'idUE' => 4,
            ],
            [
                'matiere' => 'Histoire de l’école à Madagascar',
                'poids' => 1.5,
                'idUE' => 4,
            ],
            [
                'matiere' => 'Analyse historiographique des différents systèmes scolaires à Madagascar',
                'poids' => 1.5,
                'idUE' => 4,
            ],
            [
                'matiere' => 'Méthodes graphiques',
                'poids' => 2,
                'idUE' => 5,
            ],
            [
                'matiere' => 'Statistique descriptive',
                'poids' => 2,
                'idUE' => 5,
            ],
            [
                'matiere' => 'MTU',
                'poids' => 2,
                'idUE' => 6,
            ],
            [
                'matiere' => 'TIC',
                'poids' => 2,
                'idUE' => 6,
            ],
            [
                'matiere' => 'Français',
                'poids' => 2,
                'idUE' => 6,
            ],
            [
                'matiere' => 'Introduction à la sociologie',
                'poids' => 2,
                'idUE' => 7,
            ],
            [
                'matiere' => 'Sociologie et éducation',
                'poids' => 2,
                'idUE' => 7,
            ],
            [
                'matiere' => 'Initiation à la didactique : domaine, concepts, théories',
                'poids' => 2,
                'idUE' => 8,
            ],
            [
                'matiere' => 'Processus et situations d’enseignement – apprentissage',
                'poids' => 2,
                'idUE' => 8,
            ],
            [
                'matiere' => 'Analyse des caractéristiques des situations de formation',
                'poids' => 2,
                'idUE' => 8,
            ],
            [
                'matiere' => 'Analyse globale du système éducatif formel',
                'poids' => 2,
                'idUE' => 9,
            ],
            [
                'matiere' => 'Environnement du système éducatif formel',
                'poids' => 2,
                'idUE' => 9,
            ],
            [
                'matiere' => 'Introduction à l’Education non formelle',
                'poids' => 2,
                'idUE' => 9,
            ],

            [
                'matiere' => 'Implication sociale des phénomènes physiques',
                'poids' => 2,
                'idUE' => 10,
            ],
            [
                'matiere' => 'Introduction au développement durable',
                'poids' => 2,
                'idUE' => 10,
            ],[
                'matiere' => 'diagnostic du système éducatif',
                'poids' => 2,
                'idUE' => 10,
            ],
            [
                'matiere' => 'Analyse des acteurs en milieu scolaire',
                'poids' => 2,
                'idUE' => 11,
            ],
            [
                'matiere' => 'Découverte et observation du milieu scolaire',
                'poids' => 2,
                'idUE' => 11,
            ],
//            [
//                'matiere' => 'Découverte et observation d’un milieu éducatif non formel',
//                'poids' => 2,
//                'idUE' => 11,
//            ],
            [
                'matiere' => 'Langue : Anglais',
                'poids' => 2,
                'idUE' => 12,
            ],
            [
                'matiere' => 'Initiation à la communication',
                'poids' => 2,
                'idUE' => 12,
            ],
            [
                'matiere' => 'Théories contemporaines de l’éducation',
                'poids' => 2,
                'idUE' => 13,
            ],
            [
                'matiere' => 'Introduction à l’éducation inclusive',
                'poids' => 2,
                'idUE' => 13,
            ],
            [
                'matiere' => 'Education comparée',
                'poids' => 2,
                'idUE' => 13,
            ],
            [
                'matiere' => 'Psychologie du développement',
                'poids' => 1.5,
                'idUE' => 14,
            ],
            [
                'matiere' => 'Psychosociologie et dynamique des groupes',
                'poids' => 1.5,
                'idUE' => 14,
            ],
            [
                'matiere' => 'Les différentes méthodes pédagogiques',
                'poids' => 1.5,
                'idUE' => 15,
            ],
            [
                'matiere' => 'Techniques des méthodes impositives',
                'poids' => 1.5,
                'idUE' => 15,
            ],
            [
                'matiere' => 'Outils principaux des méthodes participatives',
                'poids' => 1.5,
                'idUE' => 15,
            ],
            [
                'matiere' => 'Organisation et animation des situations d’enseignement- apprentissage',
                'poids' => 1.5,
                'idUE' => 15,
            ],
            [
                'matiere' => 'Institutionnalisation de l’école',
                'poids' => 1.5,
                'idUE' => 16,
            ],
            [
                'matiere' => 'Différents types d’institutions scolaires',
                'poids' => 1.5,
                'idUE' => 16,
            ],
            [
                'matiere' => 'Organisation administrative et pédagogique d’une institution scolaire',
                'poids' => 1.5,
                'idUE' => 16,
            ],
            [
                'matiere' => 'Introduction à la gestion de classe',
                'poids' => 1.5,
                'idUE' => 16,
            ],
            [
                'matiere' => 'Processus d’élaboration de grille de collecte de données en Sciences de l’éducation',
                'poids' => 1,
                'idUE' => 17,
            ],
            [
                'matiere' => 'Analyse et traitement des données quantitatives',
                'poids' => 2,
                'idUE' => 17,
            ],
            [
                'matiere' => 'Initiation à l’information',
                'poids' => 2,
                'idUE' => 18,
            ],
            [
                'matiere' => 'ITIC',
                'poids' => 2,
                'idUE' => 18,
            ],
            [
                'matiere' => 'Différentes formes de partenariat et de développement scolaire',
                'poids' => 2,
                'idUE' => 19,
            ],
            [
                'matiere' => 'Education et monde rural',
                'poids' => 2,
                'idUE' => 19,
            ],
            [
                'matiere' => 'Transposition didactique externe : théorie et étude de cas',
                'poids' => 2,
                'idUE' => 20,
            ],
            [
                'matiere' => 'Eléments constitutifs d’un curriculum/ Approche curriculaire',
                'poids' => 2,
                'idUE' => 20,
            ],
            [
                'matiere' => 'Méthodes et pratiques d’élaboration de curricula',
                'poids' => 2,
                'idUE' => 20,
            ],
            [
                'matiere' => 'Techniques de l’évaluation et éléments de docimologie',
                'poids' => 2.5,
                'idUE' => 21,
            ],
            [
                'matiere' => 'Différentes pratiques de validations scolaires',
                'poids' => 2.5,
                'idUE' => 21,
            ],
            [
                'matiere' => 'Education relative à l’environnement',
                'poids' => 2.5,
                'idUE' => 22,
            ],
            [
                'matiere' => 'Education à la citoyenneté et au Civisme',
                'poids' => 2.5,
                'idUE' => 22,
            ],
            [
                'matiere' => 'Découverte et observation d’une école secondaire',
                'poids' => 2.5,
                'idUE' => 23,
            ],
            [
                'matiere' => 'Découverte et observation d’un organisme de formation/ d’éducation',
                'poids' => 2.5,
                'idUE' => 23,
            ],
            [
                'matiere' => 'Langue : Anglais',
                'poids' => 2,
                'idUE' => 24,
            ],
            [
                'matiere' => 'Correspondances',
                'poids' => 2,
                'idUE' => 24,
            ],
            [
                'matiere' => 'Sciences de l’éducation : Constellation',
                'poids' => 2,
                'idUE' => 25,
            ],
            [
                'matiere' => 'Etude d’une discipline des sciences de l’éducation',
                'poids' => 2,
                'idUE' => 25,
            ],
            [
                'matiere' => 'Planification pédagogique et pratiques d’enseignement- apprentissage',
                'poids' => 2,
                'idUE' => 25,
            ],
            [
                'matiere' => 'Psychologie cognitive',
                'poids' => 2,
                'idUE' => 26,
            ],
            [
                'matiere' => 'Psychologie de l’adulte',
                'poids' => 2,
                'idUE' => 26,
            ],
            [
                'matiere' => 'Démarche d’élaboration et de mise en œuvre  d’un projet de formation',
                'poids' => 2,
                'idUE' => 27,
            ],
            [
                'matiere' => 'Education Monde Rural',
                'poids' => 2,
                'idUE' => 27,
            ],
            [
                'matiere' => 'Gestion et administration d’un établissement scolaire/ ou de formation',
                'poids' => 2,
                'idUE' => 27,
            ],
            [
                'matiere' => 'DROIT DE TRAVAIL/ENTREPRENARIAT',
                'poids' => 2,
                'idUE' => 27,
            ],
            [
                'matiere' => 'Historique de l’Education non Formelle',
                'poids' => 2,
                'idUE' => 28,
            ],
            [
                'matiere' => 'Evolution de l’Education non Formelle à Madagascar',
                'poids' => 2,
                'idUE' => 28,
            ],
            [
                'matiere' => 'Initiation à la recherche',
                'poids' => 2,
                'idUE' => 29,
            ],
            [
                'matiere' => 'Méthodologie de projet et de rédaction de rapport de stage',
                'poids' => 2,
                'idUE' => 29,
            ],
            [
                'matiere' => 'Informatique et multimédia',
                'poids' => 2,
                'idUE' => 30,
            ],
            [
                'matiere' => 'Français : Techniques d’expression en éducation',
                'poids' => 2,
                'idUE' => 30,
            ],
            [
                'matiere' => 'DROIT DE TRAVAIL',
                'poids' => 2,
                'idUE' => 30,
            ],
            [
                'matiere' => 'Fondements de l’éducation préscolaire',
                'poids' => 2,
                'idUE' => 31,
            ],
            [
                'matiere' => 'Enjeux de l’éducation préscolaire',
                'poids' => 2,
                'idUE' => 31,
            ],
            [
                'matiere' => 'Gestion et administration d’un établissement préscolaire',
                'poids' => 2,
                'idUE' => 31,
            ],
            [
                'matiere' => 'Psychologie cognitive',
                'poids' => 2,
                'idUE' => 32,
            ],
            [
                'matiere' => 'Psychologie de l’enfant',
                'poids' => 2,
                'idUE' => 32,
            ],
            [
                'matiere' => 'Pédagogie et programmes d’activités dans le préscolaire',
                'poids' => 2,
                'idUE' => 33,
            ],
            [
                'matiere' => 'Démarche d’élaboration et de mise en œuvre d’un projet de formation en préscolaire',
                'poids' => 2,
                'idUE' => 33,
            ],
            [
                'matiere' => 'Historique de l’Education préscolaire',
                'poids' => 2,
                'idUE' => 34,
            ],
            [
                'matiere' => 'Evolution de l’Education préscolaire à Madagascar',
                'poids' => 2,
                'idUE' => 34,
            ],
            [
                'matiere' => 'Initiation à la recherche',
                'poids' => 2,
                'idUE' => 35,
            ],
            [
                'matiere' => 'Méthodologie de projet et de rédaction de rapport de stage',
                'poids' => 2,
                'idUE' => 35,
            ],
            [
                'matiere' => 'Informatique et multimédia orientée à la petite enfance',
                'poids' => 2,
                'idUE' => 36,
            ],
            [
                'matiere' => 'Relation éducative',
                'poids' => 2,
                'idUE' => 37,
            ],
            [
                'matiere' => 'Les acteurs de l’éducation : enseignants, encadreurs, autres',
                'poids' => 2,
                'idUE' => 37,
            ],
            [
                'matiere' => 'Responsabilisation et animation de la communauté éducative',
                'poids' => 2,
                'idUE' => 37,
            ],
            [
                'matiere' => 'Transposition didactique interne et pratique enseignante : théorie et étude de cas d’une discipline scolaire',
                'poids' => 2,
                'idUE' => 38,
            ],
            [
                'matiere' => 'Fabrication et exploitation des matériels didactiques',
                'poids' => 2,
                'idUE' => 38,
            ],
            [
                'matiere' => 'Economie de l’éducation et analyse de l’impact économique de l’école',
                'poids' => 2,
                'idUE' => 39,
            ],
            [
                'matiere' => 'Planification, Organisation, administration et Législation spécifique de l’éducation',
                'poids' => 2,
                'idUE' => 39,
            ],
            [
                'matiere' => 'Structures d’appui au fonctionnement de l’éducation',
                'poids' => 2,
                'idUE' => 39,
            ],
            [
                'matiere' => 'Ethique et déontologie de l’éducation',
                'poids' => 2,
                'idUE' => 40,
            ],
            [
                'matiere' => 'Orientation en matière d’éducation',
                'poids' => 2,
                'idUE' => 40,
            ],
            [
                'matiere' => 'Stage et rapport de stage',
                'poids' => 2,
                'idUE' => 41,
            ],
            [
                'matiere' => 'Mémoire et soutenance',
                'poids' => 2,
                'idUE' => 41,
            ],
            [
                'matiere' => 'TIC',
                'poids' => 2,
                'idUE' => 42,
            ],
            [
                'matiere' => 'Anglais',
                'poids' => 2,
                'idUE' => 42,
            ],
            [
                'matiere' => 'GESTION DE PROJET',
                'poids' => 2,
                'idUE' => 42,
            ],
            [
                'matiere' => 'COMMUNICATION',
                'poids' => 2,
                'idUE' => 42,
            ],
            [
                'matiere' => 'Petite enfance et service corolaire : santé, nutrition, hygiène',
                'poids' => 2,
                'idUE' => 43,
            ],
            [
                'matiere' => 'Les acteurs de l’éducation préscolaire : éducateurs, animateurs, autres',
                'poids' => 2,
                'idUE' => 43,
            ],
            [
                'matiere' => 'Responsabilisation et animation de la communauté éducative',
                'poids' => 2,
                'idUE' => 43,
            ],
            [
                'matiere' => 'Didactique et démarches d’apprentissage au préscolaire',
                'poids' => 2,
                'idUE' => 44,
            ],

            [
                'matiere' => 'Fabrication et exploitation des matériels didactiques',
                'poids' => 2,
                'idUE' => 44,
            ],
            [
                'matiere' => 'Economie de l’éducation et analyse de l’impact économique de l’école',
                'poids' => 2,
                'idUE' => 45,
            ],
            [
                'matiere' => 'Planification de l’éducation',
                'poids' => 2,
                'idUE' => 45,
            ],

            [
                'matiere' => 'Organisation, administration  et Législation spécifique de l’éducation préscolaire',
                'poids' => 2,
                'idUE' => 45,
            ],

            [
                'matiere' => 'Ethique et déontologie de l’éducation préscolaire',
                'poids' => 2,
                'idUE' => 46,
            ],

            [
                'matiere' => 'Education parentale',
                'poids' => 2,
                'idUE' => 46,
            ],
            [
                'matiere' => 'Stage et rapport de stage',
                'poids' => 2,
                'idUE' => 47,
            ],
            [
                'matiere' => 'Mémoire et soutenance',
                'poids' => 2,
                'idUE' => 47,
            ],
            [
                'matiere' => 'TIC',
                'poids' => 2,
                'idUE' => 48,
            ],
            [
                'matiere' => 'Anglais',
                'poids' => 2,
                'idUE' => 48,
            ],




        ];

        ElementConstitutif::insert($matiere);
    }
}
