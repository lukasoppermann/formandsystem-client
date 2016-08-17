@if(isset($anchors) && count($anchors) > 0)
    <ul class="js-section-menu section-menu">
    @foreach ($anchors as $slug => $label)
        <li class="js-section-menu-link section-menu-link">
            <a href="#{{$slug}}">{{$label}}</a>
        </li>
    @endforeach
    </ul>
@endif
