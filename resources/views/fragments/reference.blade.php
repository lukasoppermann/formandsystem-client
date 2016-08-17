<?php
    $items      = collect($fragment['relationships']['fragments'])->sortBy('position')->keyBy('name');
    $image      = $items->pull('image');
    $img_src    = asset('media/hospital-default.png');
    $title      = $items->pull('title');
    $date       = $items->pull('Inbetriebnahme');
    $umfang     = $items->pull('Umfang');
    $areas      = $items->pull('Fachbereiche');

    // add columns
    $fragment['column'] = NULL;
    isset($fragment['meta']['columns']['sm']) ? $fragment['column'] .= ' o-grid__column--sm-'.$fragment['meta']['columns']['sm'] : '';
    isset($fragment['meta']['columns']['md']) ? $fragment['column'] .= ' o-grid__column--md-'.$fragment['meta']['columns']['md'] : '';
    isset($fragment['meta']['columns']['lg']) ? $fragment['column'] .= ' o-grid__column--lg-'.$fragment['meta']['columns']['lg'] : '';
?>
<div class="{{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}} o-fragment {{$fragment['column'] or ''}}">
    <div class="o-reference__front">
        <div class="o-reference__header">
            <div class="o-reference__image">
                <img src="{{$img_src}}" alt="{{$title['data']}}" />
            </div>
            <h4 class="{{$title['meta']['classes']}}">{{$title['data']}}</h4>
            <div class="o-reference__date">Inbetriebnahme {{$date['data']}}</div>
        </div>
        <div class="o-reference__item o-reference__item--dark">
            <div class="o-reference__item-title o-reference__item-title--red">Fachbereiche</div>
            <div class="o-reference__info">{{$areas['data']}}</div>
        </div>
        <div class="o-reference__action-bar">
            <a href="#details" class="js-card-details">Details</a>
        </div>
    </div>
    <div class="o-reference__back">
        <div class="js-close close">×</div>
        <h4 class="o-reference__title o-reference__title--white">{{$title['data']}}</h4>
        <div class="o-reference__item o-reference__important-detail">
            <div class="o-reference__item-title">{{$date['name']}}</div>
            <div class="o-reference__info">{{$date['data']}}</div>
        </div>
        <div class="o-reference__item o-reference__important-detail">
            <div class="o-reference__item-title">{{$umfang['name']}}</div>
            <div class="o-reference__info">{{$umfang['data']}}</div>
        </div>
        <div class="o-reference__details">
            @foreach($items as $item)
                @if(isset($item['data']))
                    <div class="o-reference__item">
                        <div class="o-reference__item-title">{{$item['name']}}</div>
                        <div class="o-reference__info">{{$item['data']}}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
