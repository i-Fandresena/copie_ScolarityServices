<?php

namespace Database\Seeders;

use App\Models\Droit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DroitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $droit = [
            [
                'typeDroit'           => 'PL',
                'montantDroit'          => 50000,
                'designation'          => 'Préselection L1',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM1',
                'montantDroit'          => 65000,
                'designation'          => 'Préselection M1',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM2',
                'montantDroit'          => 65000,
                'designation'          => 'Préselection M2',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM2R',
                'montantDroit'          => 120000,
                'designation'          => 'Préselection M2 Recherche',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L1',
                'montantDroit'          => 350000,
                'designation'          => 'L1',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L2',
                'montantDroit'          => 450000,
                'designation'          => 'L2',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L3',
                'montantDroit'          => 650000,
                'designation'          => 'L3',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M1',
                'montantDroit'          => 750000,
                'designation'          => 'M1',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M2',
                'montantDroit'          => 800000,
                'designation'          => 'M2',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M2R',
                'montantDroit'          => 1000000,
                'designation'          => 'M2 Recherche',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PLE',
                'montantDroit'          => 100000,
                'designation'          => 'Préselection L1 Etranger',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM1E',
                'montantDroit'          => 120000,
                'designation'          => 'Préselection M1 Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM2E',
                'montantDroit'          => 120000,
                'designation'          => 'Préselection M2 Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'PM2RE',
                'montantDroit'          => 200000,
                'designation'          => 'Préselection M2 Recherche Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L1E',
                'montantDroit'          => 350000,
                'designation'          => 'L1 Etranger',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L2E',
                'montantDroit'          => 450000,
                'designation'          => 'L2 Etranger',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'L3E',
                'montantDroit'          => 650000,
                'designation'          => 'L3 Etranger',
                'role' => 'Licence',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M1E',
                'montantDroit'          => 750000,
                'designation'          => 'M1 Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M2E',
                'montantDroit'          => 800000,
                'designation'          => 'M2 Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
            [
                'typeDroit'           => 'M2RE',
                'montantDroit'          => 1000000,
                'designation'          => 'M2 Recherche Etranger',
                'role' => 'Master',
                'createdBy' => 'admin',
            ],
        ];

        Droit::insert($droit);
    }
}
