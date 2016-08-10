<?php
    $items              = collect($fragment['relationships']['fragments'])->sortBy('position');
    $img                = collect($items->where('name','image')->first());
    $headline           = collect($items->where('name','headline')->first());
    $headline['meta']   = collect($headline['meta']);
    $text               = collect($items->where('name','text')->first());
    $text['meta']       = collect($text['meta']);
    // add columns
    $fragment['column'] = NULL;
    isset($fragment['meta']['columns']['sm']) ? $fragment['column'] .= ' o-grid__column--sm-'.$fragment['meta']['columns']['sm'] : '';
    isset($fragment['meta']['columns']['md']) ? $fragment['column'] .= ' o-grid__column--md-'.$fragment['meta']['columns']['md'] : '';
    isset($fragment['meta']['columns']['lg']) ? $fragment['column'] .= ' o-grid__column--lg-'.$fragment['meta']['columns']['lg'] : '';
?>
<div class="o-fragment {{$fragment['column']}} {{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}}">
    @if(isset($img['relationships']['images']))
        <figure class="o-image {{$img['meta']['classes'] or ''}}">
            <img class="o-image__img" src="{{asset('media/'.$img['relationships']['images'][0]['filename'])}}" alt="" />
        </figure>
    @endif
    <h2 class="{{$headline->get('meta')->get('classes','')}} {{$headline->get('meta')->get('custom_classes','')}}">
        {{$headline->get('data')}}
    </h2>
    <div class="{{$text->get('meta')->get('classes','')}} {{$text->get('meta')->get('custom_classes','')}}">
        {!! md_convert($text->get('data')) !!}
    </div>
</div>
