@if(isset($fragment['relationships']['images']))
    <figure class="o-image {{$fragment['classes'] or ''}}">
        <img class="o-image__img" src="{{asset('media/'.$fragment['relationships']['images'][0]['filename'])}}" alt="" />
    </figure>
@endif
