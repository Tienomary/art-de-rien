<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Art de Rien - Accueil</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{route('roadtrip')}}">Projet road-trip</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Me contacter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="card-selection" style="position: sticky; top: 20px; margin-bottom: 20px;">
                    <form method="get">
                        <h2>Choix des catégories</h2>
                        @foreach ($categories as $categorie)
                            <a style="color: black; cursor: pointer; display: flex; align-items: center; justify-content: space-between; margin-top: 20px;" data-bs-toggle="collapse" href="#collapseExample{{$categorie->id}}" role="button" aria-expanded="false" onclick="changeIcon({{$categorie->id}})" aria-controls="collapseExample{{$categorie->id}}">
                                <h4 style="margin: 0; text-decoration: none; display: flex; align-items: center;">
                                    @if ($categorie->image_id)
                                        @php
                                            $image = App\Models\Image::find($categorie->image_id);
                                        @endphp
                                        <img src="{{asset('storage/'.$image->name)}}" alt="categorie" width="20px" height="20px" style="margin-right: 10px;">
                                    @endif
                                    {{$categorie->name}}
                                </h4>
                                <img src="{{asset('images/down.svg')}}" alt="down" id="down{{$categorie->id}}" width="20px" height="20px">
                                <img src="{{asset('images/up.svg')}}" alt="up" id="up{{$categorie->id}}" style='display: none;' width="20px" height="20px">
                            </a>
                            <div class="collapse" id="collapseExample{{$categorie->id}}">
                                @foreach($categorie->subCategories as $subcategorie)
                                    <div class="form-check">
                                        <input class="form-check-input sub-category-checkbox" type="checkbox"  name="sub[]" value="{{ $subcategorie->id }}" data-id="{{ $subcategorie->id }}" id="subCategory{{ $subcategorie->id }}" @if(isset($_GET['sub']) && in_array($subcategorie->id, $_GET['sub'])) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$subcategorie->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        
                        <button class="btn2" type="submit" style="margin-top: 5px; width: 100%;">Filtrer</button>
                        @if (isset($_GET['sub']))
                            <button type="reset" onclick="window.location.href='{{route('mescreations')}}'" class="btn2" style="margin-top: 10px; width: 100%; background-color: #741818 !important; color: white !important; border: none !important;">Réinitialiser</button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <h1>Mes créations</h1>
                <div class="galleryTest">
                    <div class="mygrid-sizer"></div>
                    <?php if(isset($_GET['sub'])){ 
                        $cat = (request()->get('sub'));
                        $array = [];
                        foreach($creations as $creation){
                            foreach(json_decode($creation->sub_categories) as $subcategorie){
                                if(in_array($subcategorie, $cat)){
                                    $array[] = $creation;
                                }
                            }
                        }
                        foreach($array as $creation){
                            ?>
                            <div class="mygrid-item" onclick="window.location.href='{{route('creation', $creation->id)}}'">
                                <img src="{{asset('storage/'.$creation->images[0]->name)}}" alt="Image 1">
                            </div>
                            <?php
                        }
                    }else{ ?>
                    @foreach($creations as $creation)
                        <div class="mygrid-item" onclick="window.location.href='{{route('creation', $creation->id)}}'">
                            <img src="{{asset('storage/'.$creation->images[0]->name)}}" alt="Image 1">
                        </div>
                    @endforeach
                    <?php } ?>
                </div>
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
            <li class="nav-item"><a href="{{route('roadtrip')}}" class="nav-link px-2" style="color: black;">Projet road-trip</a></li>
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
    <script>
        function changeIcon(id) {
            const down = document.getElementById(`down${id}`);
            const up = document.getElementById(`up${id}`);
            if(down.style.display === 'none') {
                down.style.display = 'block';
                up.style.display = 'none';
            } else {
                down.style.display = 'none';
                up.style.display = 'block';
            }
        }
    </script>
    <script>
        // init Masonry
        var $grid = $('.galleryTest').masonry({
            itemSelector: '.mygrid-item',
            percentPosition: true,
            columnWidth: '.mygrid-sizer',
            horizontalOrder: false,
            gutter: 5
        });
        // layout Masonry after each image loads
        $grid.imagesLoaded().progress( function() {
        $grid.masonry();
        });  
    </script>
    <script src="{{asset('js/lightbox.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
