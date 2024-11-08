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
                $subCategorie = SubCategorie::find($_GET['id']);
                ?>
                <h1>Modifier une sous catégorie</h1>
                <form action="{{route('updateSubCategorie')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$subCategorie->id}}">
                    <div class="form-group">
                        <label for="name">Nom de la sous catégorie</label>
                        <input type="text" name="name" value="{{$subCategorie->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="categorie_id">Catégorie</label>
                        <select name="categorie_id" class="form-control">
                            @foreach (Categorie::all() as $categorie)
                                <option value="{{$categorie->id}}" {{ $subCategorie->category_id == $categorie->id ? 'selected' : '' }}>{{$categorie->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>

                </form>
                <?php
                break;
            case 'delete':
                $subCategorie = SubCategorie::find($_GET['id']);
                ?>
                <h1>Supprimer une sous catégorie</h1>
                <p>Voulez-vous vraiment supprimer la sous catégorie {{$subCategorie->name}} ?</p>
                <div class="alert alert-danger">
                    Si la sous catégorie contient des créations, celles-ci seront supprimées aussi.
                </div>
                <ul>
                <?php
                foreach(DB::table('creation')->whereRaw("JSON_CONTAINS(sub_categories, '\"{$subCategorie->id}\"')")->get() as $creation){
                    echo("<li>".$creation->name."</li>");
                }
                ?>
                </ul>
                <a href="./admin?page=subcategorie" class="btn btn-primary">Retour</a>
                <a href="./admin?page=subcategorie&action=confirmdelete&id={{$subCategorie->id}}" class="btn btn-danger">Supprimer</a>
                <?php
                break;
            case 'confirmdelete':
                $subCategorie = SubCategorie::find($_GET['id']);
                foreach(DB::table('creation')->whereRaw("JSON_CONTAINS(sub_categories, '\"{$subCategorie->id}\"')")->get() as $creation){
                    $creationObj = Creation::find($creation->id);
                    foreach ($creationObj->getImagesAttribute() as $image) {
                        Storage::disk('public')->delete($image->name);
                        $image->delete();
                    }
                    $creationObj->delete();
                }
                $subCategorie->delete();
                die(redirect('admin?page=subcategorie')->with('success', 'La sous catégorie a été supprimée avec succès.'));
                break;
        }
    }else{
    ?>
    <div class="col-sm-12 col-md-6">
        <h1>Sous catégories</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (SubCategorie::all() as $subCategorie)
                    <tr>
                        <td>{{ $subCategorie->name }}</td>
                        <td>{{ $subCategorie->category->name }}</td>
                        <td>
                            <a href="./admin?page=subcategorie&action=edit&id={{$subCategorie->id}}" class="btn btn-primary">Modifier</a>
                            <a href="./admin?page=subcategorie&action=delete&id={{$subCategorie->id}}" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
    <div class="col-sm-12 col-md-6">
        <h1>Ajouter une sous catégorie</h1>
        <form action="{{route('addSubCategorie')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nom de la sous catégorie</label>
                <input type="text" name="name" class="form-control" placeholder="Nom de la sous catégorie">
            </div>
            <div class="form-group">
                <label for="categorie_id">Catégorie</label>
                <select name="categorie_id" class="form-control">
                    @foreach (Categorie::all() as $categorie)
                        <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    <?php
    }
    ?>
</div>