<!DOCTYPE html>
<html lang="fr">

<head>
    @php
    use App\Http\Controllers\AfficherDonnees;
    use App\Models\Image;
    $donnees = new AfficherDonnees();
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$donnees->afficherDonneesText('titre_site')}} - Accueil</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/art-de-rien.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <meta name="description" content="{{$donnees->afficherDonneesText('description_site')}}">
    <meta name="keywords" content="{{$donnees->afficherDonneesText('keywords_site')}}">
</head>

<body>
    <style>
    .navbar {
        background-color: transparent;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
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
    .nav-item{
        font-size: 1.1rem;
    }
    </style>
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide hero-section" data-bs-ride="carousel" style="padding: 0;">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            @foreach ($donnees->afficherDonnees('images_site') as $image)
                @php
                    $imageObj = Image::find($image);
                @endphp
                <button type="button" data-bs-target="#carouselExampleIndicators" style="background-image: url('{{asset('storage/'.$imageObj->name)}}'); background-size: cover; background-position: center center;" data-bs-slide-to="{{$loop->index}}" class="{{$loop->first ? 'active' : ''}}" aria-current="true" aria-label="Slide {{$loop->index + 1}}"></button>
            @endforeach
        </div>

        <!-- Carousel Inner -->
        <div class="carousel-inner">
            @foreach ($donnees->afficherDonnees('images_site') as $image)
                @php
                    $imageObj = Image::find($image);
                @endphp
                <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                    <img src="{{asset('storage/'.$imageObj->name)}}" class="d-block w-100" style="object-fit: cover;" alt="Placeholder image 1" height="500">
                </div>
            @endforeach
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" style="font-weight: 300;" href="{{route('home')}}"><h2>L'Art de Rien</h2></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation" onclick='changeColor()'>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link active" href="{{route('home')}}">Acceuil</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('mescreations')}}">Mes créations</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('roadtrip')}}">Projet road-trip</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Me contacter</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <h1 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: {{$donnees->afficherDonnees('titre')['color']}}; font-size: 90px;" class="titre" data-aos="fade-up" data-aos-duration="2000">{{$donnees->afficherDonnees('titre')['text']}}</h1>
    </div>

    <!-- About Section -->
    <div class="about-section" style="padding: 80px 80px;">
        <div class="container">
            <h2 style="font-size:40px; margin-bottom: 0; color: {{$donnees->afficherDonnees('a_propos_de_moi_titre')['color']}}" data-aos="fade-right" data-aos-duration="3000">{{$donnees->afficherDonnees('a_propos_de_moi_titre')['text']}}</h2>
            <p style='color: {{$donnees->afficherDonnees('a_propos_de_moi_description')['color']}}' data-aos="fade-left" data-aos-duration="3500">{{substr($donnees->afficherDonnees('a_propos_de_moi_description')['text'], 0, 600)}}...</p>
            <button class="btn2" data-bs-toggle="modal" data-bs-target="#aProposeDeMoiModal" data-aos="fade-down" data-aos-duration="4000">{{$donnees->afficherDonnees('a_propos_de_moi_button')['text']}}</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="aProposeDeMoiModal" tabindex="-1" aria-labelledby="aProposeDeMoiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h1 style="margin-bottom: 0; color: {{$donnees->afficherDonnees('a_propos_de_moi_description_modal')['color']}}">{{$donnees->afficherDonnees('a_propos_de_moi_titre')['text']}}</h1>
                    <p style="color: {{$donnees->afficherDonnees('a_propos_de_moi_description_modal')['color']}}">{{$donnees->afficherDonnees('a_propos_de_moi_description_modal')['text']}}</p>
                    <button type="button" class="btn2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <hr style="width: 80%">
    <!-- Experience Section -->
    <div class="experience-section " style=" color: black;">
        <h2 style="margin-bottom: 0; font-size: 40px; color: {{$donnees->afficherDonnees('mes_competences_titre')['color']}}" data-aos="zoom-out-up">{{$donnees->afficherDonnees('mes_competences_titre')['text']}}</h2>
        <p style="color: {{$donnees->afficherDonnees('mes_competences_description')['color']}}" data-aos="zoom-out-up">{{$donnees->afficherDonnees('mes_competences_description')['text']}}</p>
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card" style="border-bottom: 1px solid rgb(138, 4, 4); border-radius: 0;" data-aos="zoom-out-right">
                        <div class="card-body text-center">
                            <img src="{{asset('images/photographie.svg')}}" alt="camera" style="width: 50px; height: 50px; color: rgb(138, 4, 4);">
                            <h5 class="card-title titre" style="font-size: 30px; color: {{$donnees->afficherDonnees('mes_competences_one_titre')['color']}}">{{$donnees->afficherDonnees('mes_competences_one_titre')['text']}}</h5>
                            <p class="card-text flex-grow-1" style="color: {{$donnees->afficherDonnees('mes_competences_one_description')['color']}}">{{$donnees->afficherDonnees('mes_competences_one_description')['text']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card" style="border-bottom: 1px solid rgb(138, 4, 4); border-radius: 0;" data-aos="zoom-out-left">
                        <div class="card-body text-center">
                            <img src="{{asset('images/peinture.svg')}}" alt="peinture" style="width: 50px; height: 50px;">
                            <h5 class="card-title titre" style="font-size: 30px; color: {{$donnees->afficherDonnees('mes_competences_two_titre')['color']}}">{{$donnees->afficherDonnees('mes_competences_two_titre')['text']}}</h5>
                            <p class="card-text flex-grow-1" style="color: {{$donnees->afficherDonnees('mes_competences_two_description')['color']}}">{{$donnees->afficherDonnees('mes_competences_two_description')['text']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card" style="border-bottom: 1px solid rgb(138, 4, 4); border-radius: 0;" data-aos="zoom-out-down">
                        <div class="card-body text-center">
                            <img src="{{asset('images/impression-3D.svg')}}" alt="impression-3D" style="width: 50px; height: 50px;">
                            <h5 class="card-title titre" style="font-size: 30px; color: {{$donnees->afficherDonnees('mes_competences_three_titre')['color']}}">{{$donnees->afficherDonnees('mes_competences_three_titre')['text']}}</h5>
                            <p class="card-text flex-grow-1" style="color: {{$donnees->afficherDonnees('mes_competences_three_description')['color']}}">{{$donnees->afficherDonnees('mes_competences_three_description')['text']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center" style="color: {{$donnees->afficherDonnees('mes_creations_titre')['color']}}" data-aos="fade-up">{{$donnees->afficherDonnees('mes_creations_titre')['text']}}</h2>

    <!-- Gallery -->
    <div class="grid">
        <div class="grid-sizer"></div>
        @foreach ($creations->take(6) as $creation)
            <div class="grid-item">
                <img src="{{asset('storage/'.$creation->images[0]->name)}}" data-aos="zoom-in" alt="{{$creation->name}}" loading="lazy" onclick="openModal('{{asset('storage/'.$creation->images[0]->name)}}')">
            </div>
        @endforeach
    </div>
    <!-- footer -->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4" style="border-top: 1px solid rgb(138, 4, 4); color: black;">
          <p class="col-md-6 mb-0">&copy; 2024 L'art de Rien</p>
      
          
      
          <ul class="nav col-md-6 justify-content-end" style="color: black;">
            <li class="nav-item"><a href="{{route('home')}}" class="nav-link px-2" style="color: black;">Accueil</a></li>
            <li class="nav-item"><a href="{{route('mescreations')}}" class="nav-link px-2" style="color: black;">Mes créations</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2" style="color: black;">Projet road-trip</a></li>
            <li class="nav-item"><a href="{{route('contact')}}" class="nav-link px-2" style="color: black;">Me contacter</a></li>
          </ul>
        </footer>
      </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        function openModal(image) {
            var modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '1000';
            modal.style.opacity = '0';
            modal.style.transition = 'opacity 0.5s';

            var img = document.createElement('img');
            img.src = image;
            img.style.maxWidth = '90%';
            img.style.maxHeight = '90%';
            img.style.transform = 'scale(0)';
            img.style.transition = 'transform 0.5s';

            modal.appendChild(img);
            document.body.appendChild(modal);

            // Animation d'ouverture
            setTimeout(function() {
                modal.style.opacity = '1';
                img.style.transform = 'scale(1)';
            }, 10);

            modal.onclick = function() {
                // Animation de fermeture
                modal.style.opacity = '0';
                img.style.transform = 'scale(0)';
                setTimeout(function() {
                    document.body.removeChild(modal);
                }, 500);
            };
        }
        
        
        function changeColor() {
            var navbar = document.querySelector('.navbar');
            if (navbar.style.backgroundColor == 'black') {
                navbar.style.backgroundColor = 'transparent';
            } else {
                navbar.style.backgroundColor = 'black';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            var $grid = $('.grid');
            $grid.imagesLoaded().progress(function() {
                $grid.masonry({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    columnWidth: '.grid-sizer',
                    gutter: 0
                });
            });
        });
    </script>
    <script>
        AOS.init();
    </script>    
</body>

</html>
