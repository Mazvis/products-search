<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="mazvis">

    <title>{{ $title }}</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('assets/bootstrap-3.0.0/dist/css/bootstrap.min.css') }}

    <!-- Custom CSS -->
    {{ HTML::style('assets/css/shop-homepage.css') }}

    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/jquery.js') }}
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/html5shiv.js') }}
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/respond.min.js') }}
    <![endif]-->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{ HTML::link('/', Lang::get('menu.'. 'brand'), ['class' => 'navbar-brand']) }}
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">{{ Lang::get('menu.'. 'about') }}</a>
                    </li>
                    <li>
                        <a href="#">{{ Lang::get('menu.'. 'contacts') }}</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Paieška</p>
                <div class="list-group">
                    <form class="" method="get" action="search">
                        <input type="text" class="form-control col-lg-12" name="s" placeholder="Ieškoti">
                    </form>
                </div>

                <p class="lead">{{ Lang::get('container.'. 'categories') }}</p>
                <div class="list-group">
                    @foreach($existingCategories as $existingCategory)
                        @if(Lang::has('categories.' . $existingCategory->category))
                            {{ HTML::link('category/' . $existingCategory->category, Lang::get('categories.'. $existingCategory->category), ['class' => 'list-group-item']) }}
                        @else
                            {{ HTML::link('category/' . $existingCategory->category, $existingCategory->category, ['class' => 'list-group-item']) }}
                        @endif
                    @endforeach
                </div>

                <p class="lead">{{ Lang::get('container.'. 'countries') }}</p>
                <div class="list-group">
                    @foreach($existingCountries as $existingCountry)
                        @if(Lang::has('countries.' . $existingCountry->country))
                            {{ HTML::link('country/' . $existingCountry->country, Lang::get('countries.'. $existingCountry->country), ['class' => 'list-group-item']) }}
                        @else
                            {{ HTML::link('country/' . $existingCountry->country, $existingCountry->country, ['class' => 'list-group-item']) }}
                        @endif
                    @endforeach
                </div>

                <p class="lead">{{ Lang::get('container.'. 'providers') }}</p>
                <div class="list-group">
                    @foreach($existingProviders as $existingProvider)
                        @if(Lang::has('providerNames.' . $existingProvider->provider))
                            {{ HTML::link('provider/' . $existingProvider->provider, Lang::get('providerNames.'. $existingProvider->provider), ['class' => 'list-group-item']) }}
                        @else
                            {{ HTML::link('provider/' . $existingProvider->provider, $existingProvider->provider, ['class' => 'list-group-item']) }}
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-md-9">

                <div class="row carousel-holder">
                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    {{HTML::image('assets/img/slider/laptop.jpg', null, array('class' => 'slide-image'))}}
                                </div>
                                <div class="item">
                                    {{HTML::image('assets/img/slider/phone.jpg', null, array('class' => 'slide-image'))}}
                                </div>
                                <div class="item">
                                    {{HTML::image('assets/img/slider/laptop.jpg', null, array('class' => 'slide-image'))}}
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                </div>

                {{ $content }}

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Mažvis, 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

<!-- Placed at the end of the document so the pages load faster -->
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.min.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/holder.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/application.js') }}

</body>

</html>