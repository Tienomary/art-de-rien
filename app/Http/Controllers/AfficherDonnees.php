<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AfficherDonnees extends Controller
{
    //
    public function afficherDonnees($nom){
        $site = \App\Models\site::first();
        return(json_decode($site->$nom, true));
    }
    public function afficherDonneesText($nom){
        $site = \App\Models\site::first();
        return($site->$nom);
    }
}
