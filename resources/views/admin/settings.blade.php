@php
    use App\Models\Creation;
    use App\Models\SubCategorie;
    use App\Models\Image;
    use Illuminate\Support\Facades\Storage;
    $user = Auth::user();
@endphp
<div class="row">
    <div class="col-sm-12" style="">
        <div style="width: 100%; margin-top: 20px;">
            <h1>Paramètres</h1>
            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <form action="{{route('editSettings')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email : </label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="password">Nouveau mot de passe : </label>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                </div>
                <div class="form-group">
                    <label for="password">Confirmer le mot de passe : </label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Mot de passe">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
                <a href="./admin?page=deconnect" class="btn btn-danger mt-3">Se déconnecter</a>
            </form>
        </div>
    </div>
</div>