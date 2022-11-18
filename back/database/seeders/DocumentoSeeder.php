<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("documentos")->insert([
            [
                "nombre" => "Documentos informativos",
                "semestre_id" => 1,
            ], [
                "nombre" => "Planificador mensual",
                "semestre_id" => 1,
            ], [
                "nombre" => "Sesiones",
                "semestre_id" => 1,
            ], [
                "nombre" => "Evidencias",
                "semestre_id" => 1,
            ]
        ]);
    }
}
