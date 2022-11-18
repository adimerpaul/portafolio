<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("semestres")->insert([
            [
                "nombre" => "1er semestre",
                "materia_id"=>"1"
            ],
            [
                "nombre" => "2do semestre",
                "materia_id"=>"1"
            ],
            [
                "nombre" => "3er semestre",
                "materia_id"=>"1"
            ],
        ]);
    }
}
