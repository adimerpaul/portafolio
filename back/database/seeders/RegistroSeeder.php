<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("registros")->insert([
            [
                "nombre" => "Registro de sistencia",
                "documento_id" => 1,
                "url"=>"www.google.com.bo"
            ], [
                "nombre" => "Informe mensual",
                "documento_id" => 1,
                "url"=>"www.google.com.bo"
            ], [
                "nombre" => "Instrumentos de evaluación",
                "documento_id" => 1,
                "url"=>"www.google.com.bo"
            ],[
                "nombre" => "Cronograma de actividades",
                "documento_id" => 2,
                "url"=>"www.google.com.bo"
            ], [
                "nombre" => "Horario de clases",
                "documento_id" => 2,
                "url"=>"www.google.com.bo"
            ],[
                "nombre" => "Clase 1",
                "documento_id" => 3,
                "url"=>"www.google.com.bo"
            ], [
                "nombre" => "Horario de clases",
                "documento_id" => 3,
                "url"=>"www.google.com.bo"
            ],[
                "nombre" => "Materiald e apoyo",
                "documento_id" => 4,
                "url"=>"www.google.com.bo"
            ], [
                "nombre" => "Resultados académicos",
                "documento_id" => 4,
                "url"=>"www.google.com.bo"
            ]
        ]);
    }
}
