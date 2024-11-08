@php
    use App\Models\Creation;
    use App\Models\SubCategorie;
    use App\Models\Image;
    use App\Models\Categorie;
    use Illuminate\Support\Facades\Storage;
@endphp
<div class="row" style="margin-top: 20px;">
    <?php
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'edit':
                $categorie = Categorie::find($_GET['id']);
                ?>
                <h1>Modifier une catégorie</h1>
                <form action="{{route('updateCategorie')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$categorie->id}}">
                    <div class="form-group">
                        <label for="name">Nom de la catégorie</label>
                        <input type="text" name="name" value="{{$categorie->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
                <?php
                break;
            case 'delete':
                $categorie = Categorie::find($_GET['id']);
                ?>
                <h1>Supprimer une catégorie</h1>
                <p>Voulez-vous vraiment supprimer la catégorie {{$categorie->name}} ?</p>
                <div class="alert alert-danger">
                    Si la catégorie contient des sous catégories, celles-ci seront supprimées. <br>
                    Si les sous catégories contiennent des créations, celles-ci seront supprimées aussi.
                </div>
                <ul>
                <?php
                foreach($categorie->subCategories as $subCategorie){
                    echo "<li>".$subCategorie->name."</li>";
                    if (DB::table('creation')->whereRaw("JSON_CONTAINS(sub_categories, '\"{$subCategorie->id}\"')")->count() > 0) {
                        echo("<ul>");
                        echo "<li>".$subCategorie->name." contient des créations</li>";
                        echo("</ul>");
                    }


                }
                ?>
                </ul>
                <a href="./admin?page=categorie" class="btn btn-primary">Retour</a>
                @if($categorie->image_id)
                    <a href="./admin?page=categorie&action=confirmdeleteimage&id={{$categorie->id}}" class="btn btn-warning" style="margin-top: 10px;">Supprimer seulement l'image</a>
                @endif
                <a href="./admin?page=categorie&action=confirmdelete&id={{$categorie->id}}" class="btn btn-danger" style="margin-top: 10px;">Supprimer</a>
                <?php
                break;
            case 'confirmdelete':
                $categorie = Categorie::find($_GET['id']);
                foreach($categorie->subCategories as $subCategorie){
                    foreach(DB::table('creation')->whereRaw("JSON_CONTAINS(sub_categories, '\"{$subCategorie->id}\"')")->get() as $creation){
                        $creationObj = Creation::find($creation->id);
                        foreach ($creationObj->getImagesAttribute() as $image) {
                            Storage::disk('public')->delete($image->name);
                            $image->delete();
                        }
                        $creationObj->delete();
                    }
                    $subCategorie->delete();
                }
                if($categorie->image_id){
                    $image = Image::find($categorie->image_id);
                    Storage::disk('public')->delete($image->name);
                    $image->delete();
                }
                $categorie->delete();

                die(redirect('admin?page=categorie')->with('success', 'La catégorie a été supprimée avec succès.'));
                break;
            case 'confirmdeleteimage':
                $categorie = Categorie::find($_GET['id']);
                $image = Image::find($categorie->image_id);
                Storage::disk('public')->delete($image->name);
                $image->delete();
                $categorie->image_id = null;
                $categorie->save();
                die(redirect('admin?page=categorie')->with('success', 'L\'image a été supprimée avec succès.'));
                break;
        }
    }else{
    ?>
    <div class="col-sm-12 col-md-6">
        <h1>Catégories</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Categorie::all() as $categorie)
                    <tr>
                        <td>{{ $categorie->name }}</td>
                        <td>
                            <a href="./admin?page=categorie&action=edit&id={{$categorie->id}}" class="btn btn-primary">Modifier</a>
                            <a href="./admin?page=categorie&action=delete&id={{$categorie->id}}" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
    <div class="col-sm-12 col-md-6">
        <h1>Ajouter une catégorie</h1>
        <div class="alert alert-warning">
            L'image sera utilisée pour la catégorie dans les créations : <a href="https://www.svgrepo.com" target="_blank">https://www.svgrepo.com</a>
        </div>
        <form action="{{route('addCategorie')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nom de la catégorie</label>
                <input type="text" name="name" class="form-control" placeholder="Nom de la catégorie">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    <?php
    }
    ?>
</div>