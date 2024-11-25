<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Art de Rien - {{$creation->name}}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/art-de-rien.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightbox.css')}}">
</head>

<body>
    <!-- Navbar -->
    <style>
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
        /* Animation d'apparition des miniatures */
        .thumbnail-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            transition: opacity 0.5s ease, transform 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .thumbnail-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .thumbnail-img {
            max-width: 100%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .thumbnail-img:hover {
            transform: scale(1.05); /* Effet de zoom au survol */
        }
    </style>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container">
            <a class="navbar-brand" style="font-weight: 300;" href="{{route('home')}}"><h2>L'Art de Rien</h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Acceuil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{route('mescreations')}}">Mes créations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('roadtrip')}}">Mes projets</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Me contacter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach($creation->images as $image)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img src="{{asset('storage/'.$image->name)}}" class="d-block w-100" alt="{{$creation->name}}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                        </button>
                </div>
                <?php if(count($creation->images) > 2) { ?>
                <div class="row mt-3">
                    <div id="thumbnails-container" class="thumbnail-container">
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <h1>{{$creation->name}}</h1>
                <p style="font-size: 1.2rem;">{{$creation->description}}</p>
                @foreach ($creation->getSubCategoriesAttributeok() as $subcategory)
                    <span class="badge" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; background-color: rgb(138, 4, 4);">{{$subcategory->name}}</span>
                @endforeach
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4" style="border-top: 1px solid rgb(138, 4, 4); color: black;">
          <p class="col-md-6 mb-0">&copy; 2024 L'art de Rien</p>
          <ul class="nav col-md-6 justify-content-end" style="color: black;">
            <li class="nav-item"><a href="{{route('home')}}" class="nav-link px-2" style="color: black;">Accueil</a></li>
            <li class="nav-item"><a href="{{route('mescreations')}}" class="nav-link px-2" style="color: black;">Mes créations</a></li>
            <li class="nav-item"><a href="{{route('roadtrip')}}" class="nav-link px-2" style="color: black;">Mes projets</a></li>
            <li class="nav-item"><a href="{{route('contact')}}" class="nav-link px-2" style="color: black;">Me contacter</a></li>
          </ul>
        </footer>
      </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Chargement de jQuery avant Masonry -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('js/lightbox.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        const images = [<?php foreach($creation->images as $image) { echo "'".asset('storage/'.$image->name)."',"; } ?>];
        const thumbnailsContainer = document.getElementById("thumbnails-container");

        let currentSlide = 0;

        function displayThumbnails() {
            thumbnailsContainer.classList.remove("visible"); // Cache les miniatures avant la transition
            setTimeout(() => {
                thumbnailsContainer.innerHTML = ''; // Vide le conteneur

                // Affiche 3 miniatures autour de l'image actuelle
                for (let i = -1; i <= 1; i++) {
                    let index = (currentSlide + i + images.length) % images.length; // Gestion circulaire des miniatures
                    let img = document.createElement("img");
                    img.src = images[index];
                    img.classList.add("img-thumbnail", "thumbnail-img", "col-4");
                    img.onclick = () => goToSlide(index);
                    thumbnailsContainer.appendChild(img);
                }
                
                thumbnailsContainer.classList.add("visible"); // Révèle les miniatures avec la transition
            }, 300); // Temps pour l'animation de disparition
        }

        function goToSlide(slideIndex) {
            const carousel = new bootstrap.Carousel('#carouselExample');
            carousel.to(slideIndex);
        }

        document.getElementById('carouselExample').addEventListener('slid.bs.carousel', function (event) {
            currentSlide = event.to; // Met à jour l'index actuel de l'image
            displayThumbnails(); // Met à jour les miniatures en fonction de l'image affichée
        });

        // Affiche les miniatures initiales
        displayThumbnails();
    </script>
</body>
</html>
