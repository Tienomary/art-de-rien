<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\Contact;
?>
<div class='row'>
    <div class="col-md-6 col-sm-12" style="margin: auto; width:100%;">
        <?php 
        if(session('error')){
            echo "<div class='alert alert-danger'>";
            echo session('error');
            echo "</div>";
        }
        if(isset($_GET['page'])){
            if($_GET['page'] == 'mdpo'){
                $motdepasse = Str::random(10);

                $validatedData = ['name' => 'Administrateur', 'email' => 'franceteamfederation@yahoo.fr', 'message' => 'Votre mot de passe temporaire est : '.$motdepasse];
                Mail::to('franceteamfederation@yahoo.fr')->send(new Contact($validatedData));
                DB::table('users')->where('id', '!=', 0)->update(['password' => Hash::make($motdepasse)]);
                ?>
                <div class="alert alert-warning">
                    Un email avec un mot de passe temporaire a été envoyé à l'adresse : franceteamfederation@yahoo.fr <br>
                    Pensez à vérifier vos spams.
                </div>
                <?php
            }
        }
        ?>
        <form action='{{route('login')}}' method='post'>
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Adresse email</label>
                <input type="email" class="form-control" name='email' style="width: 100%;">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" style="border: 1px solid rgb(222, 226, 230); border-radius: 6px; width: 100%; background-color: transparent; color: black; padding: 10px 20px;">Me connecter</button>
        </form>
        <a href="./admin?page=mdpo">Mot de passe oublié ?</a>
    </div>
</div>
