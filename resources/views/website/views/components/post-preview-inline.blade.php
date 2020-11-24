<div class="col-lg-4 col-md-12 mb-5">
    <!-- Featured image -->
    <div class="view overlay rounded z-depth-1 mb-2">
        @if($post->featured_image)
            <img src="{{$post->featured_image}}" class="img-fluid"
                 alt="$post->title">
        @else
            <img src="/img/undraw_folder_x4ft.png" class="img-fluid"
                 alt="Image not available">
        @endif

        <a>
            <div class="mask rgba-white-slight"></div>
        </a>
    </div>

    <h4 class="mb-2 mt-4 font-weight-bold">{{ $post->title }}</h4>

    <!-- Grid row -->
    <div class="row">

        <!-- Grid column -->
        <div class="col-lg-6 col-md-6 text-lg-right">
            <p class="grey-text">
                <i class="far fa-clock-o" aria-hidden="true"></i> {{ format_date($post->publish_date) }}</p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-lg-6 col-md-6 text-lg-left">
            <p class="grey-text">
                <i class="fab fa-readme" aria-hidden="true"></i> {{ read_time($post->body) }}</p>
        </div>
        <!-- Grid column -->

    </div>
    <!-- Grid row -->
    {!! $post->excerpt ? '<p class="dark-grey-text">'. $post->excerpt.'</p>':'' !!}
    <a href="{{ post_url($post->slug) }}" title="Read more - {{ $post->title }}" class="text-uppercase font-small font-weight-bold spacing">{{trans('master.Read more')}}</a>
    <hr class="mt-1" style="max-width: 90px">
</div>

