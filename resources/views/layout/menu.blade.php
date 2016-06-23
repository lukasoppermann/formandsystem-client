<nav class="o-nav c-nav--{{$slug}}">
    @foreach ($pages as $nav_item)
        <a class="o-nav__item {{$nav_item['slug'] === $active['page']['slug'] ? 'is-active' : ''}}" rel="dns-prefetch" href="{{url($nav_item['slug'])}}">{{$nav_item['menu_label']}}</a>
    @endforeach
</nav>
