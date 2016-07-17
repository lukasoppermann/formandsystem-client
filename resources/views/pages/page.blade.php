@extends('layout.app')

@section('content')

    @if(isset($active['page']['relationships']) && isset($active['page']['relationships']['fragments']))
        @foreach ($active['page']['relationships']['fragments']->sortBy('position') as $fragment)
            @includeIf('fragments.fragment', ['fragment' => $fragment])
        @endforeach
    @endif

@endsection
