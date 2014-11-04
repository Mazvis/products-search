<article>
    <h1>Home page</h1>

    <p>All products:</p>

    <div class="row">
        @foreach ($products as $product)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <a href="{{ URL::to('albums/'.'444'.'/photo/'.'444') }}">
                    {{--@if($product->id && is_file($product->images))--}}
                    {{--{{ HTML::image($photo_data_array2[$i]->photo_thumbnail_destination_url, $photo_data_array2[$i]->photo_short_description) }}--}}
                    {{--@else--}}
                    {{--{{ HTML::image('assets/img/no-image-thumb.jpg', $photo_data_array2[$i]->photo_short_description, array('width' => '200', 'height' => '200')) }}--}}
                    {{--@endif--}}
                </a>
                <div class="caption photo-link" data-id="444">
                    <p> Product: {{ HTML::link('albums/'. '444', $product->convertedPrice) }} </p>
                    <p>
                        {{ HTML::link(URL::to('albums/'.'444'.'/photo/'.'444'), 'Edit', array('class' => 'btn btn-primary', 'role' => 'button')) }}
                        {{ Form::submit('Delete', array('id' => 'delete-photo-in-home', 'class' => 'btn btn-danger')) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="clear"></div>

</article>