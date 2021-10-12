<div class="row">
    <div class="col-lg-4">
        <h3>Immagini RTC</h3>
    </div>

</div>


<div class="row">
    @foreach($images as $im)

        <div class="col-xs-6 col-md-3">
            <a   class="thumbnail">
                <img style="width: 771px; height: 500px" src="{{$im->image}}" class="img-responsive img-rounded" alt="...">
            </a>
        </div>

    @endforeach
</div>
