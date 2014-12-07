<div class="row">
    @foreach ($products as $product)
    <div class="col-sm-4 col-lg-4 col-md-4" style="padding-top: 20px; cursor:pointer;" onclick="location.href='{{$product->deepLink}}';">
        <div class="thumbnail">
            <div style="width:260px;height:160px;overflow:hidden"> <!-- height=122 -->
                <img src="{{ !empty($product->images) ? $product->images[0] : 'http://placehold.it/320x150' }}" alt="">
            </div>
            {{--<img src="http://placehold.it/320x150" alt="">--}}
            <div class="caption">
                <h4 class="pull-right">{{ $product->convertedCurrency == 'EUR' ? "€" : $product->convertedCurrency }}{{ $product->convertedPrice }}</h4>
                <h5>{{ HTML::link($product->deepLink, Lang::has('categories.' . $product->category) ? Lang::get('categories.'. $product->category) : $product->category) }}</h5>
                <p>{{ $product->description }}</p>
            </div>
            <div class="ratings">
                <p class="pull-right">{{ $product->country }}</p>
                <p>
                    <span>{{HTML::image('img/logos/' . $product->provider . '_logo.jpg', 'provider: ' . $product->provider, ['style' => 'width:70px;height:20px;'])}}</span>
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
