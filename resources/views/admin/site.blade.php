<div class='card' style="width: 100%; margin-top: 20px;">
    <h1>Site</h1>
    @php
    use App\Http\Controllers\AfficherDonnees;
    use App\Models\Image;
    $donnees = new AfficherDonnees();
    if(isset($_GET['supprimephoto'])){
        $images = json_decode(DB::table('site')->select('images_site')->where('id', 1)->first()->images_site, true);
        $position = array_search($_GET['supprimephoto'], $images);
        unset($images[$position]);
        DB::table('site')->where('id', 1)->update(['images_site' => json_encode($images)]);
        $imageobj = Image::find($_GET['supprimephoto']);
        Storage::disk('public')->delete($imageobj->name);
        $imageobj->delete();
        die(redirect()->back());
    }
    @endphp
    <form action="{{route('updateSite')}}" method="POST" class="p-4" enctype="multipart/form-data">
        @csrf
        <!-- Section Titre -->
        <h3 class="mb-3">Informations générales du site :</h3>
        <div class="mb-3">
            <label for="titre_text" class="form-label">Titre du site :</label>
            <input type="text" id="titre_text" name="titre_site" value="{{ $donnees->afficherDonneesText('titre_site') ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description_site" class="form-label">Description du site :</label>
            <input type="text" id="description_site" name="description_site" value="{{ $donnees->afficherDonneesText('description_site') ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="keywords_site" class="form-label">Mots clés (les séparer d'une virgule)</label>
            <input type="text" id="keywords_site" name="keywords_site" value="{{ $donnees->afficherDonneesText('keywords_site') ?? '' }}" class="form-control">
        </div>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Titre
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Section Titre -->
                        <h3 class="mb-3">Titre</h3>
                        <div class="mb-3">
                            <label for="titre_text" class="form-label">Texte</label>
                            <input type="text" id="titre_text" name="titre[text]" value="{{ $donnees->afficherDonnees('titre')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="titre_color" class="form-label">Couleur</label>
                            <input type="color" id="titre_color" name="titre[color]" value="{{ $donnees->afficherDonnees('titre')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <hr>
                        Images : <br>
                        <div class="mb-3">
                            <label for="titre_color" class="form-label">Nouvelles images :</label>
                            <div class="alert alert-warning">Je vous conseilles de mettre des images rectangulaires et de préferences 1920x500px</div>
                            <input type="file" name="images[]" class="form-control" multiple>
                        </div>
                        @foreach ($donnees->afficherDonnees('images_site') ?? [-1] as $image)
                            @php
                                $imageObj = Image::find($image) ?? null;
                            @endphp
                            @if ($imageObj != null):
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <img src="{{asset('storage/'.$imageObj->name)}}" alt="Image" style="width: 100px; height: 100px;">
                                    <a class="btn btn-danger btn-sm mt-1" href="./admin?page=site&supprimephoto={{$image}}">Supprimer</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    A propos de moi
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
        
                        <!-- Section A propos de moi -->
                        <h3 class="mb-3">À propos de moi</h3>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_titre_text" class="form-label">Titre</label>
                            <input type="text" id="a_propos_de_moi_titre_text" name="a_propos_de_moi_titre[text]" value="{{ $donnees->afficherDonnees('a_propos_de_moi_titre')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_titre_color" class="form-label">Couleur</label>
                            <input type="color" id="a_propos_de_moi_titre_color" name="a_propos_de_moi_titre[color]" value="{{ $donnees->afficherDonnees('a_propos_de_moi_titre')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_description_text" class="form-label">Description</label>
                            <textarea id="a_propos_de_moi_description_text" name="a_propos_de_moi_description[text]" class="form-control">{{ $donnees->afficherDonnees('a_propos_de_moi_description')['text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_description_color" class="form-label">Couleur</label>
                            <input type="color" id="a_propos_de_moi_description_color" name="a_propos_de_moi_description[color]" value="{{ $donnees->afficherDonnees('a_propos_de_moi_description')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_description_text" class="form-label">Description dans la fenêtre modale</label>
                            <textarea id="a_propos_de_moi_description_modal" name="a_propos_de_moi_description_modal[text]" class="form-control">{{ $donnees->afficherDonnees('a_propos_de_moi_description_modal')['text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_description_color" class="form-label">Couleur dans la fenêtre modale</label>
                            <input type="color" id="a_propos_de_moi_description_color" name="a_propos_de_moi_description_modal[color]" value="{{ $donnees->afficherDonnees('a_propos_de_moi_description_modal')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_description_text" class="form-label">Texte dans le bouton :</label>
                            <textarea id="a_propos_de_moi_button" name="a_propos_de_moi_button[text]" class="form-control">{{ $donnees->afficherDonnees('a_propos_de_moi_button')['text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="a_propos_de_moi_button" class="form-label">Couleur du texte dans le bouton</label>
                            <input type="color" id="a_propos_de_moi_button" name="a_propos_de_moi_button[color]" value="{{ $donnees->afficherDonnees('a_propos_de_moi_button')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Mes compétences
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Section Mes Compétences -->
                        <h3 class="mb-3">Mes Compétences</h3>
                        @foreach (['mes_competences_titre', 'mes_competences_description', 'mes_competences_one_titre', 'mes_competences_one_description', 'mes_competences_two_titre', 'mes_competences_two_description', 'mes_competences_three_titre', 'mes_competences_three_description'] as $field)
                            <div class="mb-3">
                                <label for="{{ $field }}_text" class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }} (Texte)</label>
                                <input type="text" id="{{ $field }}_text" name="{{ $field }}[text]" value="{{ $donnees->afficherDonnees($field)['text'] ?? '' }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="{{ $field }}_color" class="form-label">Couleur</label>
                                <input type="color" id="{{ $field }}_color" name="{{ $field }}[color]" value="{{ $donnees->afficherDonnees($field)['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree">
                        Mes créations
                    </button>
                </h2>
                <div id="collapseThree4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Section Mes Créations -->
                        <h3 class="mb-3">Mes Créations</h3>
                        <div class="mb-3">
                            <label for="mes_creations_titre_text" class="form-label">Texte</label>
                            <input type="text" id="mes_creations_titre_text" name="mes_creations_titre[text]" value="{{ $donnees->afficherDonnees('mes_creations_titre')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="mes_creations_titre_color" class="form-label">Couleur</label>
                            <input type="color" id="mes_creations_titre_color" name="mes_creations_titre[color]" value="{{ $donnees->afficherDonnees('mes_creations_titre')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree5" aria-expanded="false" aria-controls="collapseThree">
                        Page contact
                    </button>
                </h2>
                <div id="collapseThree5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
    
                        <!-- Section Contact -->
                        <h3 class="mb-3">Contact</h3>
                        <div class="mb-3">
                            <label for="contact_titre_text" class="form-label">Titre</label>
                            <input type="text" id="contact_titre_text" name="contact_titre[text]" value="{{ $donnees->afficherDonnees('contact_titre')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="contact_titre_color" class="form-label">Couleur</label>
                            <input type="color" id="contact_titre_color" name="contact_titre[color]" value="{{ $donnees->afficherDonnees('contact_titre')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <div class="mb-3">
                            <label for="contact_description_text" class="form-label">Description</label>
                            <textarea id="contact_description_text" name="contact_description[text]" class="form-control">{{ $donnees->afficherDonnees('contact_description')['text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact_description_color" class="form-label">Couleur</label>
                            <input type="color" id="contact_description_color" name="contact_description[color]" value="{{ $donnees->afficherDonnees('contact_description')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        
                        <!-- Champs Téléphone et Email -->
                        <div class="mb-3">
                            <label for="phone_text" class="form-label">Téléphone</label>
                            <input type="text" id="phone_text" name="phone[text]" value="{{ $donnees->afficherDonnees('phone')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="phone_color" class="form-label">Couleur</label>
                            <input type="color" id="phone_color" name="phone[color]" value="{{ $donnees->afficherDonnees('phone')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                        <div class="mb-3">
                            <label for="email_text" class="form-label">Email</label>
                            <input type="text" id="email_text" name="email[text]" value="{{ $donnees->afficherDonnees('email')['text'] ?? '' }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email_color" class="form-label">Couleur</label>
                            <input type="color" id="email_color" name="email[color]" value="{{ $donnees->afficherDonnees('email')['color'] ?? '#ffffff' }}" class="form-control form-control-color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary mt-4">Enregistrer</button>
    </form>
    
    
</div>
