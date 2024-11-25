
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/art-de-rien.png')}}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/classic/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    @php
    use App\Models\roadtrip;
@endphp
<!-- Navbar -->
<style>

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.navbar-toggler {
    border-color: rgba(255, 255, 255, 0);
    border-color: white;
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
    .navbar-brand{
        font-family: 'Pinyon Script', cursive;
    }
    .nav-item{
        font-family: 'Old London', serif;
    }
    </style>
<nav class="navbar navbar-expand-lg bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" style="font-weight: 300;" href="{{route('home')}}"><h2>L'Art de Rien</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Acceuil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('mescreations')}}">Mes créations</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{route('roadtrip')}}">Mes projets</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Me contacter</a></li>
            </ul>
        </div>
    </div>
</nav>
<style>
    /* Conteneur général de l'article */
    .article-container {
        max-width: 80%;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fdfdfd;
        clear: both;
        overflow: auto; /* Assure que le conteneur englobe les éléments flottants */
        margin-bottom: 30px; 
    }
    @font-face {
        font-family: 'Old London';
        src: url('../OldLondon.ttf');
    }
    .oldlondon {
        font-family: "Old London", serif;
    }
</style>

<?php 
if(isset($_GET['project'])){
?>
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.0/"
        }
    }
</script>
<div class="container">
    @foreach (roadtrip::where('project_id', $_GET['project'])->get()->reverse() as $article)
        <?php
        $content = $article->content; // Texte récupéré de la BDD
        $content = preg_replace_callback(
            '/<oembed url="([^"]+)"><\/oembed>/',
            function ($matches) {
                $url = $matches[1];
                // Remplace l'URL YouTube par une URL intégrable dans un iframe
                if (strpos($url, 'youtube.com') !== false) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
                    $videoId = $queryParams['v'] ?? null;
                    return $videoId ? "<iframe width='560' height='315' src='https://www.youtube.com/embed/$videoId' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>" : '';
                }
                return '';
            },
            $content
        );

        ?>
        <div class="article-container" style="display: flex; flex-direction: column;">
            <div class="ck-content">
                <h2>{{ $article->titre }}</h2>
                <div class="content">
                    {!! $content !!}
                </div>
            </div>
            <div class="date" style="display: block;">
                <p style="font-size: 12px; color: #666;">{{ $article->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    @endforeach
</div>
<?php }else{ 
    if(DB::table('project')->count() == 1){
        die(redirect('./roadtrip?project='.DB::table('project')->first()->id));
    }
    ?>
    <div class="container">
        <h2 style="font-family: 'Pinyon Script', cursive;">
            Parcourez mes différents projets sur lesquels je travaille :
        </h2>
        <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px;">
        @foreach(DB::table('project')->get() as $project)
            <a href="{{route('roadtrip', ['project' => $project->id])}}" class="btn btn-outline-danger" style="flex: 1;">{{$project->name}}</a>
        @endforeach
        </div>
    </div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>