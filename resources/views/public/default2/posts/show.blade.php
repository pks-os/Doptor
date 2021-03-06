{{-- Update the Meta Description --}}
@section('meta_description')
    @if ($post->meta_description)
        <meta name="description" content="{!! $post->meta_description !!}" />
    @endif
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
    @if ($post->meta_keywords)
        <meta name="keywords" content="{!! $post->meta_keywords !!}" />
    @endif
@stop

@section('content')
    <div class="container">
        <?php
            $menu = Menu::published()
                    ->where(function($query) {
                        $query->where('link', '=', Request::path())
                                ->orWhere('link_manual', '=', Request::path());
                    })
                    ->first();
            if ($menu) {
                $type = $menu->title;
            } else {
                $type = 'News';
            }
        ?>
        <ul class="breadcrumb">
            <li><a href="{!! url('/') !!}">Home</a></li>
            @if (Request::is('pages/*'))
                <li><a href="{!! url('pages') !!}">Pages</a></li>
            @else
                <li><a href="{!! url('posts') !!}">{!! ucwords($type) !!}</a></li>
            @endif
            <li class="current">{!! ucwords($post->permalink) !!}</li>
        </ul>

        <div class="row margin-bottom-40">
            <!-- BEGIN POST -->
            <div class="col-md-9 col-sm-9 blog-posts">

                <article class="post">

                    <!-- begin post heading -->
                    <header class="entry-header">
                        <h2 class="entry-title">
                            {!! HTML::link('posts/'.$post->permalink, $post->title) !!}
                        </h2>
                    </header>
                    <!-- end post heading -->

                    <!-- begin post content -->
                    <div class="entry-content">
                        <!-- begin post image -->
                        <figure class="featured-thumbnail full-width">
                            @if ($type == 'post')
                                <span class="meta-date">
                                    <span class="meta-date-inner">
                                        {!! $post->date() !!}
                                    </span>
                                </span>
                            @endif
                            @if ($post->image)
                                <img src="{!! url($post->image) !!}" alt="" width="636" height="179" border="0" />
                            @endif
                        </figure>
                        <!-- end post image -->

                        {!! $post->content !!}
                    </div>
                    <!-- end post heading -->

                </article>
            </div>
            <!-- END POST -->

            <!-- BEGIN SIDEBAR -->
            @include("public.$current_theme.posts.sidebar")
            <!-- END SIDEBAR -->
        </div>

    </div>
@stop

@section('scripts')
    @if ($post->type != 'post')
    <script>
        $(function() {
            $('#sidebar').find(".sf-menu").removeClass('sf-menu');

            $header_menu = $('header .sf-menu>li');

            for (i=0; i<=($header_menu.length/2)-1; i++) {
                $header_menu[i].remove();
            }
        });
    </script>
    @endif
@stop
