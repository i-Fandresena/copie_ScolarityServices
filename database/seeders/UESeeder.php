<?php

namespace Database\Seeders;

use App\Models\UniteEnseignement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ue = [
            [
                'designation'           => 'APPROCHE GENERALE DE L’EDUCATION',
                'credit'          => 4,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'APPROCHE PSYCHOLOGIQUE DES SITUATIONS EDUCATIVES',
                'credit'          => 4,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'PRINCIPALES IDEES ET APPROCHES PEDAGOGIQUES',
                'credit'          => 6,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'APPROCHE HISTORIQUE DE L’EDUCATION',
                'credit'          => 6,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'METHODOLOGIE',
                'credit'          => 4,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 6,
                'session'          => 'S1',
                'niveau'       => 'L1',
            ],
//            S2 ******************
            [
                'designation'           => 'APPROCHE SOCIOLOGIQUE DU CHAMP DE L’EDUCATION',
                'credit'          => 4,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'APPROCHE DIDACTIQUE DE L’EDUCATION',
                'credit'          => 6,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'APPROCHE GLOBALE DU SYSTEME EDUCATIF',
                'credit'          => 6,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'EDUCATION AU DEVELOPPEMENT DURABLE',
                'credit'          => 4,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'OBSERVATION ET ANALYSE DU MILIEU EDUCATIF ET SCOLAIRE',
                'credit'          => 6,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 4,
                'session'          => 'S2',
                'niveau'       => 'L1',
            ],
//            S3 ****************************
            [
                'designation'           => 'OUTILS THEORIQUES DE BASE',
                'credit'          => 6,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'BASES PSYCHOLOGIQUES DU DEVELOPPEMENT INDIVIDUEL ET SOCIAL',
                'credit'          => 3,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'PRATIQUES PEDAGOGIQUES',
                'credit'          => 6,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'ORGANISATION ET GESTION DE L’INSTITUTION SCOLAIRE',
                'credit'          => 6,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'METHODOLOGIE',
                'credit'          => 3,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 6,
                'session'          => 'S3',
                'niveau'       => 'L2',
            ],
//            S4 ****************
            [
                'designation'           => 'APPROCHE ECOSYSTEMIQUE DE L’EDUCATION',
                'credit'          => 5,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'PROCESSUS DIDACTIQUE D’ELABORATION DES CURRICULA',
                'credit'          => 6,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'EVALUATION EN MILIEU EDUCATIF ET SCOLAIRE',
                'credit'          => 5,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'EDUCATION ET QUESTIONS SOCIALEMENT VIVES (QSV)',
                'credit'          => 5,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],
            [
                'designation'           => 'OBSERVATION ET ANALYSE DU MILIEU EDUCATIF ET SCOLAIRE',
                'credit'          => 5,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],

            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 4,
                'session'          => 'S4',
                'niveau'       => 'L2',
            ],
//            S5 ********************
            [
                'designation'           => 'EPISTEMOLOGIE DES SCIENCES DE L’EDUCATION',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'BASES PSYCHOLOGIQUES DE L’APPROPRIATION DES SAVOIRS',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'GESTION DE L’INTERVENTION EN MILIEU EDUCATIF ET SCOLAIRE',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'APPROCHE HISTORIQUE DE L’EDUCATION NON FORMELLE',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'METHODOLOGIE',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
//            S5  EDUCATION PRESCOLAIRE
            [
                'designation'           => 'APPROCHE GENERALE DE L’EDUCATION PRESCOLAIRE',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],[
                'designation'           => 'BASES PSYCHOLOGIQUES DE L’APPROPRIATION DES SAVOIRS',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'PRATIQUES D’EDUCATION PRESCOLAIRE',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'APPROCHE HISTORIQUE DE L’EDUCATION PRESCOLAIRE',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'METHODOLOGIE',
                'credit'          => 4,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES I',
                'credit'          => 6,
                'session'          => 'S5',
                'niveau'       => 'L3',
            ],
//            S6 ***********************
            [
                'designation'           => 'APPROCHE INTERACTIVE DE L’EDUCATION',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'FORMALISATION DIDACTIQUE ET APPROPRIATION DES SAVOIRS',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS DE GESTION DU SYSTEME EDUCATIF',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'EDUCATION ET ETHIQUE',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'PRATIQUES EN MILIEU EDUCATIF ET SCOLAIRE',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
//            S6 EDUCTION PRESCOLAIRE
            [
                'designation'           => 'APPROCHE INTERACTIVE DE L’EDUCATION PRESCOLAIRE',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'DEMARCHE DIDACTIQUE APPROPRIEE AU PRESCOLAIRE',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS DE GESTION DU SYSTEME EDUCATIF',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'EDUCATION ET ETHIQUE',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'PRATIQUES EN MILIEU PRESCOLAIRE',
                'credit'          => 4,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
            [
                'designation'           => 'OUTILS ET RENFORCEMENT DES COMPETENCES I',
                'credit'          => 6,
                'session'          => 'S6',
                'niveau'       => 'L3',
            ],
        ];

        UniteEnseignement::insert($ue);
    }
}
