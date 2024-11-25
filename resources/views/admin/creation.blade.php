@php
    use App\Models\Creation;
    use App\Models\SubCategorie;
    use App\Models\Image;
    use Illuminate\Support\Facades\Storage;
@endphp
<div class="row">
    <?php
    if(isset($_GET['action']) && $_GET['action'] == 'edit'){
        $creation = Creation::find($_GET['id']);
        if(isset($_GET['up'])){
            $images = json_decode(DB::table('creation')->select('images')->where('id', $_GET['id'])->first()->images, true);
            $position = array_search($_GET['up'], $images);
            $images2 = $images[$position-1];
            $images[$position-1] = $images[$position];
            $images[$position] = $images2;
            DB::table('creation')->where('id', $_GET['id'])->update(['images' => json_encode($images)]);
            die(redirect()->back());
        }
        if(isset($_GET['down'])){
            $images = json_decode(DB::table('creation')->select('images')->where('id', $_GET['id'])->first()->images, true);
            $position = array_search($_GET['down'], $images);
            $images2 = $images[$position+1];
            $images[$position+1] = $images[$position];
            $images[$position] = $images2;
            DB::table('creation')->where('id', $_GET['id'])->update(['images' => json_encode($images)]);
            die(redirect()->back());
        }
        if(isset($_GET['delete'])){
            if(sizeof($creation->images) > 1){
                $images = json_decode(DB::table('creation')->select('images')->where('id', $_GET['id'])->first()->images, true);
                $position = array_search($_GET['delete'], $images);
                unset($images[$position]);
                DB::table('creation')->where('id', $_GET['id'])->update(['images' => json_encode($images)]);
                $imageobj = Image::find($_GET['delete']);
                Storage::disk('public')->delete($imageobj->name);
                $imageobj->delete();
            }
            die(redirect()->back());
        }
        ?>
        <div class="col-sm-12" style="">
            <div style="width: 100%; margin-top: 20px;">
                <h1>Modifier une création</h1>
                <?php
                if(session('error')){
                    echo "<div class='alert alert-danger'>".session('error')."</div>";
                }
                ?>
                <form action="{{route('editCreation', ['id' => $creation->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom de la création</label>
                        <input type="text" name="name" class="form-control" placeholder="Nom de la création" value="{{$creation->name}}">
                    </div>  
                    <div class="form-group">
                        <label for="description">Description de la création</label>
                        <textarea name="description" class="form-control" placeholder="Description de la création">{{$creation->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="images">Images de la création</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                    </div>
                    <div class="form-group">
                        <label for="sub_categories">Sous catégories de la création</label>
                        @foreach (SubCategorie::all() as $sub_categorie)
                            <div class="form-check">
                                <input type="checkbox" name="sub_categories[]" class="form-check-input" value="{{$sub_categorie->id}}" @if(in_array($sub_categorie->id, json_decode($creation->sub_categories, true))) checked @endif>
                                <label class="form-check-label" for="sub_categories">{{$sub_categorie->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form><br>
                <?php
                $i = 0;
                ?>
                @foreach ($creation->images as $image)
                    <?php
                    $i++;
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <img src="{{asset('storage/'.$image->name)}}" alt="{{$creation->name}}" style="width: 200px; height: 200px;"><br>
                            <?php
                            if($i != 1 && $i != count($creation->images)){
                                ?>
                                <a href="./admin?page=creation&action=edit&id={{$creation->id}}&up={{$image->id}}" class="btn btn-primary small">Monter</a><br>
                                <a href="./admin?page=creation&action=edit&id={{$creation->id}}&down={{$image->id}}" class="btn btn-primary small">Descendre</a>
                                <?php
                            }
                            if($i == count($creation->images)){
                                ?>
                                <a href="./admin?page=creation&action=edit&id={{$creation->id}}&up={{$image->id}}" class="btn btn-primary small">Monter</a>
                                <?php
                            }
                            if($i == 1){
                                ?>
                                <a href="./admin?page=creation&action=edit&id={{$creation->id}}&down={{$image->id}}" class="btn btn-primary small">Descendre</a>
                                <?php
                            }
                            ?>  
                            <a href="./admin?page=creation&action=edit&id={{$creation->id}}&delete={{$image->id}}" class="btn btn-danger small">Supprimer</a>
                        </div> 
                    </div>
                @endforeach
            </div>
        </div>
        <?php
    }elseif (isset($_GET['action']) && $_GET['action'] == 'delete'){
        $creation = Creation::find($_GET['id']);
        foreach ($creation->getImagesAttribute() as $image) {
            Storage::disk('public')->delete($image->name);
            $image->delete();
        }
        $creation->delete();
        die(redirect()->back()->with('success', 'La création a été supprimée avec succès.'));
    }else{
    ?>
    <div class="col-md-6 col-sm-12" style="">
        <div  style="width: 100%; margin-top: 20px;">
            <h1>Vos créations</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Aperçu</th>
                        <th>Sous catégories</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Creation::all() as $creation)
                        <tr>
                            <td>{{ $creation->name }}</td>
                            <td><img src="{{asset('storage/'.$creation->getImagesAttribute()[0]->name)}}" alt="{{$creation->name}}" style="width: 100px; height: 100px;"></td>
                            <td>
                                @foreach (json_decode($creation->sub_categories, true) as $subCategorie)
                                    @php
                                        $subCategorieObj = SubCategorie::find($subCategorie);
                                    @endphp
                                    <span class="badge bg-primary">{{$subCategorieObj->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="./admin?page=creation&action=edit&id={{$creation->id}}" class="btn btn-primary">Modifier</a>
                                <a href="./admin?page=creation&action=delete&id={{$creation->id}}" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6 col-sm-12" style="">
        <div style="width: 100%; margin-top: 20px;">
            <h1>Ajouter une création</h1>
            <?php
            if(session('error')){
                echo "<div class='alert alert-danger'>".session('error')."</div>";
            }
            ?>
            <form action="{{route('addCreation')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nom de la création</label>
                    <input type="text" name="name" class="form-control" placeholder="Nom de la création" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="description">Description de la création</label>
                    <input type="text" name="description" class="form-control" placeholder="Description de la création" value="{{old('description')}}">
                </div>
                <div class="form-group">
                    <label for="images">Images de la création</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                </div>
                <div class="form-group">
                    <label for="sub_categories">Sous catégories de la création</label>
                    @foreach (SubCategorie::all() as $sub_categorie)
                        <div class="form-check">
                            <input type="checkbox" name="sub_categories[]" class="form-check-input" value="{{$sub_categorie->id}}">
                            <label class="form-check-label" for="sub_categories">{{$sub_categorie->name}}</label>
                        </div>
                    @endforeach
                </div>
                <br>
                <button type="submit" class="btn2">Ajouter</button>
            </form>
        </div>
    </div>
    <?php 
    }
    ?>
</div>