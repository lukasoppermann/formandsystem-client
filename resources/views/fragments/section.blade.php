<section class="o-section o-grid {{$fragment['classes'] or ''}} {{$fragment['custom_classes'] or ''}} {{$fragment['column'] or ''}}">
    @if(isset($fragment['relationships']['fragments']))
        @foreach ($fragment['relationships']['fragments']->sortBy('position') as $subfragment)
            @includeIf('fragments.fragment', ['fragment' => $subfragment])
        @endforeach
    @endif
</section>
