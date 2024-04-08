<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('species')->insert([
            ['name'=>'SURUBI PINTADO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'SURUBI ATIGRADO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'PATI / FALSO PATI', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'TAPE', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'ARMADO CHANCHO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'ARMADO GALLEGO O COMUN', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MANDUBA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MANDUBE ESTRELLA O 3 PUNTOS', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MANDUBE CUCHARA O PICO PATO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MONCHOLO BLANCO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'AMARILLO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'BOGA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'CORVINA DE RIO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'DENTUDO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'BRILLANTE O VIRREYNA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'OJON O PORTEÑO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'PICUDO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'AZULINO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'PALOMETA MORA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'PIRAÑA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'BAGRE CORRENTADA', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'BAGRE CHALECO', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MARIETA COMUN', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'MARIETA RAYADA O BOQUENSE', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'APRETADOR', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'PIRAYAGUA O CHAFALOTE', 'points1'=>200,'points2'=>10,'larger'=>false],
            ['name'=>'RAYA', 'points1'=>200,'points2'=>10,'larger'=>false]
        ]);
    }
}
