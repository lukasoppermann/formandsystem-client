<?php
    dd($fragment);
?>
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
