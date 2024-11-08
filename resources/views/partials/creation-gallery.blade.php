<div class="mygrid-sizer"></div>
@foreach($creations as $creation)
    <div class="mygrid-item" onclick="window.location.href='{{route('creation', $creation->id)}}'">
        <img src="{{asset('storage/'.$creation->images[0]->name)}}" alt="Image 1">
    </div>
@endforeach
@if(sizeof($subCategoryIds) == 0):
    <div class="mygrid-item">
        <p>Aucune création trouvée</p>
    </div>
@endif
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
