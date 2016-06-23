<section class="o-section o-grid {{$fragment['classes'] or ''}} {{$fragment['column'] or ''}}">
    @if(isset($fragment['relationships']['fragments']))
        @foreach ($fragment['relationships']['fragments'] as $subfragment)
            @includeIf('fragments.fragment', ['fragment' => $subfragment])
        @endforeach
    @endif
</section>
