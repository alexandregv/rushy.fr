@extends('default')


@section('content')
  <section class="header-homepage">
      <div class="block-title stats">
        <span class="title">Statistiques</span>
        <div></div>
      </div>
    </section>

    <section class="content-stats">
	  <section class="row mb-5" style="width: 70%;">
		@foreach($dieux as $dieu)
		  <section class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" style="text-align: center;">
            <h2>Dieu {{ $dieu['text'] }}</h2>
            <a href="{{ route('stats', ['username' => $dieu['data']->name]) }}">
              <img src="https://crafatar.com/avatars/{{ $dieu['data']->uuid }}?size=100">
              <h4>{{ $dieu['data']->name }}</h4>
            </a>
            <h3>{{ $dieu['data']->kills }} kills à son actif</h3>
          </section>
		@endforeach
      </section>
      
      <section>
        <form class="form-inline float-right" onsubmit="window.location = '/stats/' + document.getElementById('searchPseudo').value; return false;">
		  <input type="text" id="searchPseudo" class="form-control mr-2" placeholder="Pseudo" value="">
          <button type="submit" class="form-control btn-warning" style="cursor: pointer;">Rechercher</button>
        </form>
      </section>
      
      <section>
        <h1>RushBox</h1>
        <table class="table">
          <tbody>
            <thead>
              <tr>
                <th>N°</th>
                <th>Pseudo</th>
                <th>Kills</th>
                <th>Deaths</th>
                <th>K/D</th>
              </tr>
            </thead>
            @foreach($stats_rushbox as $stat)
              <tr class="allow-select">
                <th>{{ $loop->iteration }}</th>
                <th>{{ $stat->name }}</th>
                <td>{{ $stat->kills }}</td>
                <td>{{ $stat->deaths }}</td>
                <td>{{ round($stat->KD, 2) }}</td>
                <!--<td>{{ round($stat->kills / max($stat->deaths, 1), 2) }}</td>-->
              </tr>
            @endforeach
          </tbody>
        </table>

		<h1>Rush</h1>
        <table class="table">
          <tbody>
            <thead>
              <tr>
                <th>N°</th>
                <th>Pseudo</th>
                <th>Kills</th>
                <th>Deaths</th>
                <th>K/D</th>
              </tr>
            </thead>
            @foreach($stats_rush as $stat)
              <tr class="allow-select">
                <th>{{ $loop->iteration }}</th>
                <th>{{ $stat->name }}</th>
                <td>{{ $stat->kills }}</td>
                <td>{{ $stat->deaths }}</td>
                <td>{{ round($stat->KD, 2) }}</td>
                <!--<td>{{ round($stat->kills / max($stat->deaths, 1), 2) }}</td>-->
              </tr>
            @endforeach
          </tbody>
        </table>

        <h1>RushTheFlag</h1>
        <table class="table">
          <tbody>
            <thead>
              <tr>
                <th>N°</th>
                <th>Pseudo</th>
                <th>Wins</th>
                <!--<th>Loses</th>-->
                <!--<th>Win %</th>-->
                <th>Kills</th>
                <th>Deaths</th>
                <th>K/D</th>
                <th>Score</th>
              </tr>
            </thead>
            @foreach($stats_rtf as $stat)
              <tr class="allow-select">
                <th>{{ $loop->iteration }}</th>
                <th>{{ $stat->name }}</th>
                <td>{{ $stat->wins }}</td>
                <!--<td>{{ $stat->loses }}</td>-->
                <!--<td>{{ round($stat->winrate) }}%</td>-->
                <td>{{ $stat->kills }}</td>
                <td>{{ $stat->deaths }}</td>
                <td>{{ round($stat->KD, 2) }}</td>
                <td>{{ $stat->score }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </section>
    </section>
    
@endsection
