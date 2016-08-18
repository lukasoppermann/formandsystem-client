@if( strpos($fragment['custom_classes'], 'js-collection-with-search') !== false)
    <div class="js-collection-search">
        <input class="o-reference-search-box" type="search" name="name" value="" />
        <div class="stream-itemCount js-searchable-itemCount"></div>
    </div>
@endif
<div class="o-collection o-grid {{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}} {{$fragment['column'] or ''}}">
    @if(isset($fragment['relationships']['collections']) && isset($fragment['relationships']['collections']->first()['relationships']['fragments']))
        @foreach(collect($fragment['relationships']['collections']->first()['relationships']['fragments'])->sortBy('position') as $element)
            <?php
                // add css classes
                $element['classes'] = isset($element['meta']['classes']) ? str_replace('.','',$element['meta']['classes']) : '';
                $element['custom_classes'] = isset($element['meta']['custom_classes']) ? str_replace('.','',$element['meta']['custom_classes']) : '';
            ?>
            @includeIf('fragments.'.$element['type'], ['fragment' => $element])
        @endforeach
    @endif
</div>
