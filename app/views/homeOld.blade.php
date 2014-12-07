<div class="row">

    @foreach ($products as $product)
    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail image-to-transform">
            <img src="{{ !empty($product->images) ? $product->images[0] : 'http://placehold.it/320x150' }}" alt="">
            {{--<img src="http://placehold.it/320x150" alt="">--}}
            <div class="caption">
                <h4 class="pull-right">{{ $product->convertedCurrency == 'EUR' ? "€" : $product->convertedCurrency }}{{ $product->convertedPrice }}</h4>
                <h4>{{ HTML::link($product->deepLink, Lang::has('categories.' . $product->category) ? Lang::get('categories.'. $product->category) : $product->category) }}</h4>
                <p>{{ $product->description }}</p>
            </div>
            <div class="ratings">
                <p class="pull-right">{{ $product->country }}</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                </p>
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-sm-4 col-lg-4 col-md-4">
        <h4><a href="#">Like this template?</a>
        </h4>
        <p>If you like this template, then check out <a target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this tutorial</a> on how to build a working review system for your online store!</p>
        <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
    </div>

</div>
