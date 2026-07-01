<?php

namespace Database\Seeders;

use App\Models\Parcours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParcoursL3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parcours = [
            [
                'libelle' => 'Education Générale',
            ],
            [
                'libelle' => 'Education Préscolaire',
            ],
        ];

        Parcours::insert($parcours);
    }
}
