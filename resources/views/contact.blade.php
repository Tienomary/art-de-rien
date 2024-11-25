<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Art de Rien - Contact</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/art-de-rien.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/contact_style.css')}}">
</head>
<body>
    @php
    use App\Http\Controllers\AfficherDonnees;
    $donnees = new AfficherDonnees();
    @endphp
    <style>
        @media (min-width: 992px) {
        .rs {
                margin-top: 100px;
            }
        }

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.navbar-toggler {
    border-color: rgba(255, 255, 255, 0);
    border-color: white;
}
        .navbar {
            background-color: transparent;
            z-index: 10;
            transition: all 0.3s;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .navbar-brand:hover {
            color: #fff;
            transition: all 0.3s;
        }

        .navbar-nav .nav-link {
            color: #fff;
            margin-right: 15px;
        }

        .navbar-nav .nav-link.active {
            color: #ccc;
        }
    </style>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: transparent;">
        <div class="container">
            <a class="navbar-brand" style="font-weight: 300;" href="{{route('home')}}">L'Art de Rien</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Acceuil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('mescreations')}}">Mes créations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('roadtrip')}}">Mes projets</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{route('contact')}}">Me contacter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="rest">
    <div class="stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <div class="container text-white rs" style="z-index: 10;">
        <div class="row">
            <h1 class="text-center">Vous souhaitez me contacter ?</h1>
            <p class="text-center">Vous pouvez me joindre en remplissant le formulaire ci-dessous ou en utilisant mes informations de contact.</p>
            <div class="col-md-6 text-white">
                @if(session('success'))
                <p class="text-center">{{session('success')}}</p>
                @endif
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message :</label>
                        <textarea class="form-control" id="message" name="message" placeholder="Message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            <div class="col-md-6 text-white text-center d-flex flex-column justify-content-center align-items-center gap-2">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <img src="{{asset('images/phone.svg')}}" alt="Artwork 4" loading="lazy" width="20px" height="20px">
                    <p style="margin:0;">{{$donnees->afficherDonnees('phone')['text']}}</p>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <img src="{{asset('images/mail.svg')}}" alt="Artwork 4" loading="lazy" width="20px" height="20px">
                    <p style="margin:0;">{{$donnees->afficherDonnees('email')['text']}}</p>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <img src="{{asset('images/qrcode_art-de-rien.fr.png')}}" alt="Artwork 4" loading="lazy" width="30%" style="border-radius: 15%;">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</div>
</body>
<script>

function changeColor() {
            var navbar = document.querySelector('.navbar');
            if (navbar.style.backgroundColor == 'black') {
                navbar.style.backgroundColor = 'transparent';
            } else {
                navbar.style.backgroundColor = 'black';
            }
        }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>