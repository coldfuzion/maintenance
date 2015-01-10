@if($asset->images->count() > 0)
    <style>
        .slider-size {
            height: 200px;
            width: 300px;
        }

        .carousel {
            width: 100%;
            margin: 0 auto;
        }
    </style>

    <div class="slider-size">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @if($asset->images->count() > 1)
                    @foreach($asset->images as $image)
                        @if($asset->images->first()->id == $image->id)
                            <li data-target="#carousel-example-generic" data-slide-to="" class="active"></li>
                        @else
                            <li data-target="#carousel-example-generic" data-slide-to="" class=""></li>
                        @endif
                    @endforeach
                @endif
            </ol>
            <div class="carousel-inner">
                @if($asset->images->count() > 0)
                    @foreach($asset->images as $image)
                        <div class="item @if($asset->images->first()->id == $image->id) active @endif">
                            <div
                                    style="background:url({{ Storage::url($image->file_path.$image->file_name) }}) center center; background-size:cover;"
                                    class="slider-size">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if($asset->images->count() > 1)
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            @endif
        </div>
    </div>

@endif