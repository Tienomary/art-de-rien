<div class='container' style='margin-top: 20px;'>
    <div style='display: flex; justify-content: space-between; align-items: center; flex-direction: row;'>
        <a href="./admin?page=site" class='btn btn-outline-primary'>Éditer le site</a>
        <a href="./admin?page=creation" class='btn btn-outline-primary'>Éditer les créations</a>
        <a href="./admin?page=categorie" class='btn btn-outline-primary'>Éditer les catégories</a>
        <a href="./admin?page=subcategorie" class='btn btn-outline-primary'>Éditer les sous catégories</a>
        <a href="./admin?page=roadtrip" class='btn btn-outline-primary'>Éditer les projets / articles</a>
        <a href="./admin" class='btn btn-outline-primary'>Paramètres</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success" style='margin-top: 20px;'>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style='margin-top: 20px;'>
            {{ session('error') }}
        </div>
    @endif
        <?php 
        use App\Models\Creation;
        if(isset($_GET['page'])){ 
            switch($_GET['page']){
                case 'site':
                    echo view('admin.site');
                    break;
                case 'creation':
                    echo view('admin.creation');
                    break;
                case 'categorie':
                    echo view('admin.categorie');
                    break;  
                case 'subcategorie':
                    echo view('admin.subcategorie');
                    break;
                case 'roadtrip':
                    echo view('admin.roadtrip');
                    break;
                case 'deconnect':
                    Auth::logout();
                    return redirect()->route('admin');
                    break;
                case 'project':
                    echo view('admin.project');
                    break;
                default:
                    echo view('admin.settings');
                    break;

            }
        }else{
            echo view('admin.settings');
        }
        ?> 

</div>
