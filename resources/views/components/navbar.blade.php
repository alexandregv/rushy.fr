<nav class="navbar navbar-expand-lg navbar-settings navbar-bgl fixed-top">
  <a class="navbar-brand" href="/"><span>RUSHY</span></a>
  <div class="navbar-border navbar-brand-bar"></div>
  <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      @php if(!isset($page) || empty($page)) $page = ""; @endphp
      <li class="nav-item @if($page == 'Accueil') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('index') }}>Accueil</a></li>
      <li class="nav-item @if($page == 'Jeux') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('jeux') }}>Jeux</a></li>
      <li class="nav-item @if($page == 'Stats') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('stats') }}>Stats</a></li>
      <li class="nav-item @if($page == 'Reglement') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('reglement') }}>Règlement</a></li>
      <li class="nav-item @if($page == 'Staff') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('staff') }}>Staff</a></li>
      <li class="nav-item @if($page == 'Boutique') {{ " active-nav " }} @endif"><a class="nav-link" href={{ route('boutique') }}>Boutique</a></li>
    </ul>
    <ul class="navbar-nav">
      @if(Session::has('admin'))
        <li class="nav-item-admin @if($page == 'Panel admin') {{ " active-nav-admin" }} @endif"><a class="nav-link" href="{{ route('admin.panel') }}">Panel</a></li>
      @endif 
    </ul>
  </div>
</nav>
