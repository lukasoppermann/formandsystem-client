<section class="o-section o-grid {{$fragment['classes'] or ''}} {{$fragment['column'] or ''}}">
    @if(count($fragment['relationships']['fragments']) > 0)
        @foreach ($fragment['relationships']['fragments'] as $subfragment)
            @includeIf('fragments.fragment', ['fragment' => $subfragment])
        @endforeach
    @endif
</section>
