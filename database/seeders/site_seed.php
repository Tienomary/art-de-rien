<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\site;

class site_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $site = new site();
        $site->id(1);
        $site->titre = json_encode(['text' => 'L\'Art de Rien', 'color' => 'white']);
        $site->a_propos_de_moi_titre = json_encode(['text' => 'A propos de moi', 'color' => 'white']);
        $site->a_propos_de_moi_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->a_propos_de_moi_description_modal = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->a_propos_de_moi_button = json_encode(['text' => 'En savoir plus', 'color' => 'white']);
        $site->mes_competences_titre = json_encode(['text' => 'Mes compétences', 'color' => 'white']);
        $site->mes_competences_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->mes_competences_one_titre = json_encode(['text' => 'HTML', 'color' => 'white']);
        $site->mes_competences_one_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->mes_competences_two_titre = json_encode(['text' => 'CSS', 'color' => 'white']);
        $site->mes_competences_two_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->mes_competences_three_titre = json_encode(['text' => 'JavaScript', 'color' => 'white']);
        $site->mes_competences_three_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->mes_creations_titre = json_encode(['text' => 'Mes créations', 'color' => 'white']);
        $site->contact_titre = json_encode(['text' => 'Contact', 'color' => 'white']);
        $site->contact_description = json_encode(['text' => 'Je suis un développeur web fullstack et un artiste en ligne. Je suis passionné par la création de sites web et de applications mobiles. Je suis également un artiste en ligne et je suis passionné par la création de sites web et de applications mobiles.', 'color' => 'white']);
        $site->phone = json_encode(['text' => 'Téléphone', 'color' => 'white']);
        $site->email = json_encode(['text' => 'Email', 'color' => 'white']);
        $site->save();
    }
}
