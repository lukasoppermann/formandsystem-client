<div class="footer">
  <ul class="navigation--footer">
    <li><a href="{{url('kontakt')}}">Kontakt</a></li>
    {{-- <li><a href="{{url('karriere')}}">Karriere</a></li>
    <li><a href="{{url('impressum')}}">Impressum</a></li> --}}
    @if(isset($menu_footer['pages']))
        @foreach($menu_footer['pages'] as $key => $item)
            <li><a href="{{$item['slug']}}">{{$item['menu_label']}}</a></li>
        @endforeach
    @endif
    <li><a href="{{url('files')}}">Kunden-Login</a></li>
  </ul>

  <div class="legal">
    <p class="copyright">Copyright {{date("Y")}}<span class="separator--dot">•</span>COPRA System GmbH<span class="separator--dot">•</span>All Rights Reserved</p>
    <a class="link--quiet" href="{{url('datenschutzrichtlinien')}}">Datenschutzrichtlinien</a>
  </div>

</div>
