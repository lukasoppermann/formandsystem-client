@if($main_section && $anchor !== "")
    <?php
        $anchors->add($anchor);
        $anchor = str_slug($anchor);
        $anchor_id = 'id='.$anchor.' name='.$anchor.'';
    ?>

@endif
<section {{$anchor_id or ''}} class="o-section o-grid {{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}} {{$fragment['column'] or ''}}">
    @if(isset($fragment['relationships']['fragments']))
        @foreach ($fragment['relationships']['fragments']->sortBy('position') as $subfragment)
            @includeIf('fragments.fragment', ['fragment' => $subfragment, 'main_section' => false])
        @endforeach
    @endif
</section>
