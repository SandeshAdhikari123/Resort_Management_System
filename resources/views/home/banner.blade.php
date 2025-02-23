@if($banners->count() > 0)
    <section class="banner_main">
        <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($banners as $index => $banner)
                    <li data-target="#myCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ asset('assets/uploads/banner/' . $banner->image) }}" alt="Slide {{ $index + 1 }}" style="height:500px; object-fit:cover;">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
@else
    <p>Banner does not exist.</p>
@endif
