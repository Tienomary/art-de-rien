<div class="container">
    <h1>Création de projet</h1>
    <?php
    if(isset($_GET['deleteconfirm'])){
        if(DB::table('project')->count() > 1){
            DB::table('roadtrip')->where('project_id', $_GET['deleteconfirm'])->delete();
            DB::table('project')->where('id', $_GET['deleteconfirm'])->delete();
            die(redirect('admin?page=project')->with('success', 'Le projet a été supprimé avec succès.'));
        }else{
            die(redirect('admin?page=project')->with('error', 'Vous ne pouvez pas supprimer le dernier projet.'));
        }
    }
    if(isset($_GET['delete'])){
        $project = DB::table('project')->where('id', $_GET['delete'])->first();

        ?>
        <ul>
        @foreach(DB::table('roadtrip')->where('project_id', $_GET['delete'])->get() as $roadtrip)
            @if($loop->first)
                Ce projet contient les articles suivants (ils seront supprimés avec le projet) :
            @endif
            <li>{{$roadtrip->titre}}</li>
        @endforeach
        </ul>
        <div class="alert alert-danger">
            Vous êtes sur le point de supprimer le projet {{$project->name}}. Voulez-vous continuer ?
            <a href="./admin?page=project" class="btn btn-primary">Annuler</a>
            <a href="./admin?page=project&deleteconfirm={{$project->id}}" class="btn btn-danger">Supprimer</a>
        </div>
        <?php
    }else{
    ?>
    <?php if(isset($_GET['project'])): ?>
    <form method="POST" action="{{route('updateproject', ['id' => $_GET['project']])}}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="name">Nom du projet :</label>
            <input type="text" name="name" placeholder="Nom du projet" class="form-control" value="{{DB::table('project')->where('id', $_GET['project'])->first()->name}}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Modifier</button>
    </form>
    <?php else: ?>
    <form method="POST" action="{{route('createproject')}}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="name">Nom du projet :</label>
            <input type="text" name="name" placeholder="Nom du projet" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Créer</button>
    </form>
    <?php endif; ?>
    <?php if(!isset($_GET['project'])): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(DB::table('project')->get() as $project)
                <tr>
                    <td>{{$project->name}}</td>
                    <td>
                        <a href="./admin?page=project&project={{$project->id}}" class="btn btn-primary">Modifier</a>
                        <a href="./admin?page=project&delete={{$project->id}}" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    <?php endif; ?>
    <?php } ?>
</div>
