<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\site;
use App\Models\Creation;
use App\Models\Image;
use App\Models\Categorie;
use App\Mail\Contact;
use App\Models\SubCategorie;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function showForm(){
        return view('admin.form');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Redirige vers un lien spécifique en cas d'échec de validation
            return redirect('admin')->with('error', 'Veuillez remplir tous les champs.')->withInput();
        }else{
            $user = User::where('email', $request->email)->first();
            if($user && Hash::check($request->password, $user->password)){
                Auth::login($user);
                return redirect('admin');
            }else{
                return redirect('admin')->with('error', 'Email ou mot de passe incorrect.');
            }
        }
    }
    public function editSettings(Request $request){
        $user = Auth::user();
        if($request->input('email') != ""){
            $user->email = $request->input('email');
        }
        if($request->input('password') != "" && $request->input('password_confirmation') != ""){
            if($request->input('password') == $request->input('password_confirmation')){
                $user->password = Hash::make($request->input('password'));
            }else{
                return redirect('admin')->with('error', 'Les mots de passe ne correspondent pas.');
            }
        }
        $user->save();
        return redirect('admin')->with('success', 'Les données ont été mises à jour avec succès.');
    }
    public function updateSite(Request $request){
        // Récupérer les données existantes
        $donnees = Site::findOrFail(1);

        // Encodage JSON pour chaque champ
        $donnees->titre = json_encode($request->input('titre'));
        $donnees->a_propos_de_moi_titre = json_encode($request->input('a_propos_de_moi_titre'));
        $donnees->a_propos_de_moi_description = json_encode($request->input('a_propos_de_moi_description'));
        $donnees->a_propos_de_moi_description_modal = json_encode($request->input('a_propos_de_moi_description_modal'));
        $donnees->a_propos_de_moi_button = json_encode($request->input('a_propos_de_moi_button'));
        $donnees->mes_competences_titre = json_encode($request->input('mes_competences_titre'));
        $donnees->mes_competences_description = json_encode($request->input('mes_competences_description'));
        $donnees->mes_competences_one_titre = json_encode($request->input('mes_competences_one_titre'));
        $donnees->mes_competences_one_description = json_encode($request->input('mes_competences_one_description'));
        $donnees->mes_competences_two_titre = json_encode($request->input('mes_competences_two_titre'));
        $donnees->mes_competences_two_description = json_encode($request->input('mes_competences_two_description'));
        $donnees->mes_competences_three_titre = json_encode($request->input('mes_competences_three_titre'));
        $donnees->mes_competences_three_description = json_encode($request->input('mes_competences_three_description'));
        $donnees->mes_creations_titre = json_encode($request->input('mes_creations_titre'));
        $donnees->contact_titre = json_encode($request->input('contact_titre'));
        $donnees->contact_description = json_encode($request->input('contact_description'));
        $donnees->phone = json_encode($request->input('phone'));
        $donnees->email = json_encode($request->input('email'));

        $donnees->titre_site = $request->input('titre_site');
        $donnees->description_site = $request->input('description_site');
        $donnees->keywords_site = $request->input('keywords_site');

        // Enregistrer les modifications
        $donnees->save();

        $imagePaths = [];
        $images_id = [];
        if(sizeof(json_decode($donnees->images_site, true)) > 0){
            foreach(json_decode($donnees->images_site, true) as $image){
                $images_id[] = $image;
            }
        }
        // Vérifiez que l'on a des fichiers
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $imagePaths[] = $imagePath;
                $imageobj = new Image();
                $imageobj->name = $imagePath;
                $imageobj->save();
                $images_id[] = $imageobj->id;
            }
            $donnees->images_site = json_encode($images_id);
            $donnees->save();
        }

        // Rediriger avec un message de succès
        return redirect()->route('admin')->with('success', 'Les données ont été mises à jour avec succès.');
    }
    public function addCreation(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'images.*' => 'required|image|min:1|mimes:jpeg,jpg,png,gif,svg,pdf',
            'sub_categories' => 'required'
        ]);

        $imagePaths = [];
        $images_id = [];
    
        if ($validator->fails()) {
            // Redirige vers un lien spécifique en cas d'échec de validation
            return redirect('admin?page=creation')->with('error', 'Veuillez remplir tous les champs.')->withInput();
        }else{
            // Vérifiez que l'on a des fichiers
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imagePaths[] = $imagePath;
                    $imageobj = new Image();
                    $imageobj->name = $imagePath;
                    $imageobj->save();
                    $images_id[] = $imageobj->id;
                }
            }
            $creation = new Creation();
            $creation->name = $request->input('name');
            $creation->description = $request->input('description');
            $creation->images = json_encode($images_id);
            $creation->categories = json_encode('ok');
            $creation->sub_categories = json_encode($request->input('sub_categories'));
            $creation->save();
            return redirect('admin?page=creation')->with('success', 'La création a été ajoutée avec succès.');
        }
    }
    public function editCreation(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'images.*' => 'required|image|min:1|mimes:jpeg,jpg,png,gif,svg,pdf,webp',
            'sub_categories' => 'required'
        ]);

        $imagePaths = [];
        $images_id = [];

        $creation = Creation::find($id);
        foreach($creation->images as $image){
            $images_id[] = $image->id;
        }
    
        if ($validator->fails()) {
            // Redirige vers un lien spécifique en cas d'échec de validation
            return redirect('admin?page=creation&action=edit&id='.$id)->with('error', 'Veuillez remplir tous les champs.')->withInput()->withErrors($validator);
        }else{
            // Vérifiez que l'on a des fichiers
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imagePaths[] = $imagePath;
                    $imageobj = new Image();
                    $imageobj->name = $imagePath;
                    $imageobj->save();
                    $images_id[] = $imageobj->id;
                }
            }
            $creation->name = $request->input('name');
            $creation->description = $request->input('description');
            $creation->images = json_encode($images_id);
            $creation->categories = json_encode('ok');
            $creation->sub_categories = json_encode($request->input('sub_categories'));
            $creation->save();
            return redirect('admin?page=creation')->with('success', 'La modification a été enregistrée avec succès.');
        }
    }

    public function addCategorie(Request $request){
        // Vérifiez que l'on a des fichiers
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imageobj = new Image();
            $imageobj->name = $imagePath;
            $imageobj->save();
        }
        $categorie = new Categorie();
        $categorie->name = $request->input('name');
        $categorie->image_id = $imageobj->id ?? null;
        $categorie->save();
        return redirect('admin?page=categorie')->with('success', 'La catégorie a été ajoutée avec succès.');
    }
    public function updateCategorie(Request $request){
        if ($request->hasFile('image')) {
            $categorie = Categorie::find($request->input('id'));
            if($categorie->image_id){
                $image = Image::find($categorie->image_id);
                Storage::disk('public')->delete($image->name);    
                $image->delete();
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $imageobj = new Image();
            $imageobj->name = $imagePath;
            $imageobj->save();
            $categorie = Categorie::find($request->input('id'));
            $categorie->name = $request->input('name');
            $categorie->image_id = $imageobj->id;
            $categorie->save();
        }else{
            $categorie = Categorie::find($request->input('id'));
            $categorie->name = $request->input('name');
            $categorie->save();
        }
        return redirect('admin?page=categorie')->with('success', 'La catégorie a été modifiée avec succès.');
    }
    public function addSubCategorie(Request $request){
        $subCategorie = new SubCategorie();
        $subCategorie->name = $request->input('name');
        $subCategorie->category_id = $request->input('categorie_id');
        $subCategorie->save();
        return redirect('admin?page=subcategorie')->with('success', 'La sous catégorie a été ajoutée avec succès.');
    }
    public function updateSubCategorie(Request $request){
        $subCategorie = SubCategorie::find($request->input('id'));
        $subCategorie->name = $request->input('name');
        $subCategorie->category_id = $request->input('categorie_id');
        $subCategorie->save();
        return redirect('admin?page=subcategorie')->with('success', 'La sous catégorie a été modifiée avec succès.');
    }
    public function filterCreations(Request $request){
        $subCategoryId = $request->get('subcategory_ids');

        // Filtrer les créations par sous-catégorie
        $subCategoryIds = explode(',', $subCategoryId);
        
        $array = array();
        foreach($subCategoryIds as $subCategoryId){
            foreach(Creation::get() as $creation){
                foreach(json_decode($creation->sub_categories) as $cate){
                    if($cate == $subCategoryId){
                        $array[] = $creation;
                    }
                }
            }
        }
        if($subCategoryIds[0] == ""){
            $creations = Creation::get();
        }else{
            $creations = $array;
        }

        // Retourner une vue partielle avec seulement les créations filtrées
        return view('partials.creation-gallery', compact('creations', 'subCategoryIds'));
    }
    public function addProject(Request $request){
        DB::table('project')->insert([
            'name' => $request->input('name')
        ]);
        return redirect('admin?page=roadtrip')->with('success', 'Le projet a été ajouté avec succès.');
    }
    public function updateProject(Request $request, $id){
        DB::table('project')->where('id', $id)->update([
            'name' => $request->input('name')
        ]);
        return redirect('admin?page=roadtrip')->with('success', 'Le projet a été modifié avec succès.');
    }

    public function sendContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $mailto = json_decode(Site::findOrFail(1)->email, true);
        Mail::to($mailto['text'])->send(new Contact($validatedData));

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }

}
