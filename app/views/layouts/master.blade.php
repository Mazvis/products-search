<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="mazvis">

    <title>{{ $title }}</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('assets/bootstrap-3.0.0/dist/css/bootstrap.min.css') }}

    <!-- Style css-->
    {{ HTML::style('assets/css/style.css') }}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/jquery.js') }}
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/html5shiv.js') }}
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/respond.min.js') }}
    <![endif]-->
</head>

<body class="{{ $bodyClass }}">
<div class="container">
    <div class="container">

        <div class="nav-relative">
            <nav class="navbar navbar-default navbar-absolute" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button class="toggle-sidebar navbar-toggle" type="button" data-target=".main-sidebar" title="Toggle sidebar">
                        <span class="sr-only">Toggle sidebar</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" title="Toggle menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{ HTML::link('/', 'Products cearch', array('class' => 'navbar-brand')) }}
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        {{--<li class="@if(Request::is('/'))active@endif">{{ HTML::link('/', 'Home') }}</li>--}}
                    </ul>
                </div>
            </nav>
        </div>
        <div class="page-content">

            <aside class="main-sidebar">

                <div class="photo-search">
                    {{--{{ Form::open(array('route' => 'search.photo', 'method' => 'post', 'id' => 'search-form')) }}--}}
                    {{--<input type="search" placeholder="Search photos" class="form-control" name="photo-search-by-tag" id="search" autocomplete="off">--}}
                    {{--{{ Form::token() }}--}}
                    {{--{{ Form::close() }}--}}
                </div>

                <div class="photo-search sidebar-elements" style="display:none">
                    <h5>Random product</h5>
                    <div class="thumbnail">
                    </div>
                </div>

                <div class="photo-search sidebar-elements">
                    <h5>All categories</h5>
                    <div class="thumbnail">
                        <?php $i = 0; ?>
                        @foreach($existingCategories as $existingCategory)
                        {{ HTML::link('category/'.$existingCategory, $existingCategory) }}@if($i++ < sizeOf($existingCategories)-1), @endif
                        @endforeach
                    </div>
                </div>

                <address class="copyright">
                    &copy; 2014 Mazvis<sup>xMx</sup>
                </address>

                <div class="clear"></div>
            </aside>

            <!-- main content -->
            <div class="main-content">
                {{ $content }}
            </div>
            <!-- main content end -->

        </div>

    </div>
</div>
<!-- Placed at the end of the document so the pages load faster -->
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.min.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/holder.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/application.js') }}

</body>
</html>