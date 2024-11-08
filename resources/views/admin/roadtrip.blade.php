<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
<style>
    @font-face {
        font-family: 'Old London';
        src: url('../OldLondon.ttf');
    }
    .oldlondon {
        font-family: "Old London", serif;
    }
</style>
@php
    use App\Models\roadtrip;
    use App\Models\Image;
    use Illuminate\Support\Facades\Storage;
@endphp
<?php 
if(isset($_GET['delete'])){
    $article = roadtrip::find($_GET['delete']);
    $images = Image::where('article_id', $article->id)->get();
    foreach($images as $image){
        Storage::disk('public')->delete($image->name);
        $image->delete();
    }
    $article->delete();
    die(redirect()->back()->with('success', 'article supp'));
}
?>
<?php if(isset($_GET['edit'])): $article = roadtrip::find($_GET['edit']) ?>
    <form method="POST" action="{{route('updateRoadTrip', $article->id)}}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="title">Titre de l'article :</label>
            <input type="text" name="title" placeholder="Titre de l'article" class="form-control" value="{{$article->titre}}" required>
        </div>
        <label for="content">Contenu de l'article :</label>
        <textarea name="content" id="editor" rows="10">{{$article->content}}</textarea>
        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
<?php else: ?>
    <form method="POST" action="{{route('createroadtrip')}}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="title">Titre de l'article :</label>
            <input type="text" name="title" placeholder="Titre de l'article" class="form-control" required>
        </div>
        <label for="content">Contenu de l'article :</label>
        <textarea name="content" id="editor" rows="10"></textarea>
        <button type="submit" class="btn btn-primary mt-3">Publier</button>
    </form>
<?php endif; ?>
<div class="container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (roadtrip::all()->reverse() as $article)
                    <tr>
                        <td>{{ $article->titre }}</td>
                        <td>{{ $article->created_at->format('d/m/Y à H:i') }}</td>
                        <td>
                            <a href="./admin?page=roadtrip&edit={{ $article->id }}" class="btn btn-warning">Editer</a>
                            <a href="./admin?page=roadtrip&delete={{ $article->id }}" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.0/"
        }
    }
</script>
<script>
    class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('upload', file);

                fetch('{{ route("ckeditor.upload") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.url) {
                        resolve({
                            default: result.url
                        });
                    } else {
                        reject(result.message || 'Upload failed');
                    }
                })
                .catch(reject);
            }));
    }

    abort() {
        // Ici tu peux gérer une logique pour annuler le téléchargement si nécessaire.
    }
}
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph,
        Image,
        ImageInsert,
        ImageResizeEditing, 
        ImageResizeHandles,
        ImageToolbar,
        Alignment,
        ImageStyle,
        List,
        HorizontalLine,
        Heading,
        MediaEmbed,
    } from 'ckeditor5';

    function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            plugins: [ Essentials, MediaEmbed,Heading,Bold, Italic, Font, Paragraph, Image, ImageInsert, ImageResizeEditing, ImageResizeHandles, ImageToolbar, ImageStyle, Alignment, List, HorizontalLine],
            fontFamily: {
                options: [
                    'default',
                    'Old London',
                    'Pinyon Script'
                ]
            },
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'alignment', '|',
                'Heading', 'fontFamily', 'fontColor', '|', 'bulletedList', 'numberedList', 'horizontalLine', 'insertImage', 'mediaEmbed'
            ],
            image: {
                toolbar: [
                    'imageStyle:alignLeft',     // Alignement à gauche
                    'imageStyle:alignCenter',   // Alignement au centre
                    'imageStyle:alignRight',    // Alignement à droite
                    'imageStyle:block',         // Image en bloc
                    'imageStyle:inline',        // Image inline
                    'imageResize:resizeImage',  // Redimensionnement de l'image
                    'imageResize:resizeImageByPercentage', // Redimensionnement par pourcentage
                ],
                resizeUnit: '%',               // Utilisation de pourcentage pour le redimensionnement
                styles: [
                    'imageStyle:alignLeft',     // Style d'image alignée à gauche
                    'imageStyle:alignCenter',   // Style d'image centrée
                    'imageStyle:alignRight',    // Style d'image alignée à droite
                    'imageStyle:block',         // Image en bloc
                    'imageStyle:inline',        // Image inline
                ],
                // Ajout d'options de redimensionnement
                insert: {
                    type: 'auto'                // Type d'insertion automatique
                }
            },
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
        } )
        .then( /* ... */ )
        .catch(error => {
            console.error(error);
        });
</script>