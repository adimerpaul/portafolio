<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("materias")->insert([
            [
                "nombre" => "Programación 1",
                "user_id" => 1,
            ], [
                "nombre" => "Programación grafica",
                "user_id" => 1,
            ], [
                "nombre" => "Analisis de sistemas",
                "user_id" => 1,
            ]
        ]);
    }
}
