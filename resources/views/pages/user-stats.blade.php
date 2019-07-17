@extends('default')


@section('content')
  <section class="header-homepage">
    <div class="block-title stats">
      <span class="title">Statistiques de {{ $stats_rushbox->name }}</span>
      <div></div>
    </div>
  </section>
  
  <section class="content-stats">
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
              <tr>
                <th>{{ $pos_rushbox }}</th>
                <th>{{ $stats_rushbox->name }}</th>
                <td>{{ $stats_rushbox->kills }}</td>
                <td>{{ $stats_rushbox->deaths }}</td>
                <td>{{ round($stats_rushbox->KD, 2) }}</td>
              </tr>
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
              <tr>
                <th>{{ $pos_rush }}</th>
                <th>{{ $stats_rush->name }}</th>
                <td>{{ $stats_rush->kills }}</td>
                <td>{{ $stats_rush->deaths }}</td>
                <td>{{ round($stats_rush->KD, 2) }}</td>
              </tr>
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
              <tr>
                <th>{{ $pos_rtf }}</th>
                <th>{{ $stats_rtf->name }}</th>
                <td>{{ $stats_rtf->wins }}</td>
                <!--<td>{{ $stats_rtf->loses }}</td>-->
                <!--<td>{{ round($stats_rtf->winrate) }}%</td>-->
                <td>{{ $stats_rtf->kills }}</td>
                <td>{{ $stats_rtf->deaths }}</td>
                <td>{{ round($stats_rtf->KD, 2) }}</td>
                <td>{{ $stats_rtf->score }}</td>
              </tr>
          </tbody>
        </table>

      </section>
    </section>
@endsection
