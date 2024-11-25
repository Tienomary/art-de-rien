<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\roadtrip;

class roadtripecontroler extends Controller
{
    //

    public function createRoadTrip(Request $request){
        $roadtrip = new roadtrip();
        $roadtrip->content = $request->input('content');
        $roadtrip->titre = $request->input('title');
        $roadtrip->project_id = $request->input('project');
        $roadtrip->save();
        $images = Image::where('article_id', -1)->get();
        foreach($images as $image){
            $image->article_id = $roadtrip->id;
            $image->save();
        }
        return redirect('./admin?page=roadtrip')->with('success', 'Article créé avec succès');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('uploads', 'public');  // Stockage dans le disque 'public'
            $url = asset('storage/' . $path);  // Génère l'URL publique de l'image
            $image = new Image();
            $image->name = $path;
            $image->article_id = -1;
            $image->save();

            return response()->json([
                'url' => $url  // Retourne l'URL publique pour CKEditor
            ]);
        } else {
            return response()->json(['message' => 'Aucun fichier reçu'], 400);
        }
    }

    public function updateRoadTrip(Request $request, $id){
        $roadtrip = roadtrip::find($id);
        $roadtrip->content = $request->input('content');
        $roadtrip->titre = $request->input('title');
        $roadtrip->project_id = $request->input('project');
        $roadtrip->save();
        return redirect('./admin?page=roadtrip')->with('success', 'Article mis à jour avec succès');
    }
    
}
