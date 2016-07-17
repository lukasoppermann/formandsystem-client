<?php
        // add css classes
        $fragment['classes'] = isset($fragment['meta']['classes']) ? str_replace('.','',$fragment['meta']['classes']) : '';
        $fragment['custom_classes'] = isset($fragment['meta']['custom_classes']) ? str_replace('.','',$fragment['meta']['custom_classes']) : '';
        // add columns
        $fragment['column'] = NULL;
        isset($fragment['meta']['columns']['sm']) ? $fragment['column'] .= ' o-grid__column--sm-'.$fragment['meta']['columns']['sm'] : '';
        isset($fragment['meta']['columns']['md']) ? $fragment['column'] .= ' o-grid__column--md-'.$fragment['meta']['columns']['md'] : '';
        isset($fragment['meta']['columns']['lg']) ? $fragment['column'] .= ' o-grid__column--lg-'.$fragment['meta']['columns']['lg'] : '';
?>

@if($fragment['type'] !== 'section')
    <div class="o-fragment {{$fragment['column'] or ''}} {{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}}">
@endif
    @if(View::exists('fragments.'.$fragment['type']))
        @include('fragments.'.$fragment['type'], $fragment)
    @else
        @if(isset($fragment['relationships']['fragments']))
            @foreach(collect($fragment['relationships']['fragments'])->sortBy('position') as $element)
                <?php
                    // add css classes
                    $element['classes'] = isset($element['meta']['classes']) ? str_replace('.','',$element['meta']['classes']) : '';
                    $element['custom_classes'] = isset($element['meta']['custom_classes']) ? str_replace('.','',$element['meta']['custom_classes']) : '';
                ?>
                @includeIf('fragments.'.$element['type'], ['fragment' => $element])
            @endforeach
        @endif
    @endif

@if($fragment['type'] !== 'section')
    </div>
@endif
