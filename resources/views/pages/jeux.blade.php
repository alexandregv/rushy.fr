@extends('default')


@section('content')
  <section class="header-homepage">
      <div class="block-title jeux">
        <span class="title">Nos jeux</span>
      </div>
    </section>
    
    <section class="content-games">
      <section class="row games-block">
        @foreach($games as $game)
          <div class="col-12 game-card">
            <div class="">
              <img src="{{$game->image->large->url}}" alt="{{ $game->name }}">
            </div>
            <div class="game-card-desc-title">
              <div class="game-card-title">
                <h3>{{ $game->name }}</h3>
              </div>
              <hr class="separator-title-desc">
              <div class="game-card-desc">
                <p>{{ $game->description }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </section>
    </section>
@endsection