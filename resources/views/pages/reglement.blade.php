@php

function itor($number) {
	$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
	$returnValue = '';
	while ($number > 0) {
		foreach ($map as $roman => $int) {
			if($number >= $int) {
				$number -= $int;
				$returnValue .= $roman;
				break;
			}
		}
	}
	return $returnValue;
}

@endphp

@extends('default')

@section('content')
  <section class="header-homepage">
    <div class="block-title rules">
      <span class="title">Règlement</span>
      <div></div>
    </div>
  </section>

  <section class="content-rules">
	@foreach ($rules as $rule)
    	<section class="rule-block">
    	  <div>
    	    <h3>Article {{ itor($rule->id) }}</h3>
    	    <hr class="hr-rule-title">
    	  </div>
    	  <div>
    	    <p>
    	      <span style="color: #333; font-weight: 700;">{{ $rule->title }}: </span>{{ $rule->content }}
    	    </p>
    	  </div>
    	</section>
	@endforeach

    <section class="end-message">
      <h6>Bon jeu sur le serveur Rushy ! L'équipe de Rushy.</h6>
    </section>

  </section>


@endsection
