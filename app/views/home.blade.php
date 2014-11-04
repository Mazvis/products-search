<article>
    <h1>Home page</h1>

    <p>{{ $textLikeTitle }}</p>

    <div class="row">
        @foreach ($products as $product)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption photo-link" data-id="444">
                    <p> Price: {{ $product->convertedPrice }} </p>
                    <p> Currency: {{ $product->convertedCurrency }} </p>
                    <p> Category: {{ $product->category }} </p>
                    <p> Country: {{ $product->country }} </p>
                    <p>{{ HTML::link($product->deepLink, 'link to product') }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="clear"></div>

</article>