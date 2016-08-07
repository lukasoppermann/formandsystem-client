<?php
    $items              = collect($fragment['relationships']['fragments'])->sortBy('position');
    $year               = collect($items->where('name','year')->first());
    $year['meta']       = collect($year['meta']);
    $text               = collect($items->where('name','text')->first());
    $text['meta']       = collect($text['meta']);
?>
<div class="{{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}} o-fragment {{$fragment['column'] or ''}}">
    <span class="o-timeline-item-visual"></span>
    <h4 class="{{$year->get('meta')->get('classes','')}} {{$year->get('meta')->get('custom_classes','')}}">
        {{$year->get('data')}}
    </h4>
    <div class="{{$text->get('meta')->get('classes','')}} {{$text->get('meta')->get('custom_classes','')}}">
        {!! md_convert($text->get('data')) !!}
    </div>
</div>
