<?php
    if(isset($fragment['relationships']['metadetails'])){
        $details = array_column($fragment['relationships']['metadetails']->toArray(),'data','type');
        // add css classes
        $fragment['classes'] = isset($details['classes']) ? str_replace('.','',$details['classes']) : '';
        // add columns
        $fragment['column'] = NULL;
        isset($details['columns_small']) ? $fragment['column'] .= ' o-grid__column--sm-'.$details['columns_small'] : '';
        isset($details['columns_medium']) ? $fragment['column'] .= ' o-grid__column--md-'.$details['columns_medium'] : '';
        isset($details['columns_large']) ? $fragment['column'] .= ' o-grid__column--lg-'.$details['columns_large'] : '';
    }
?>

@if($fragment['type'] !== 'section')
    <div class="o-fragment {{$fragment['column'] or ''}}">
@endif

    @includeIf('fragments.'.$fragment['type'], $fragment)

@if($fragment['type'] !== 'section')
    </div>
@endif
