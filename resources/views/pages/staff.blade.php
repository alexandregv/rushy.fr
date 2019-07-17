@extends('default')


@section('content')

    <section class="header-homepage">
      <div class="block-title staff">
        <span class="title">Staff</span>
      </div>
    </section>
    
    <section class="content-staff">
      <section class="rank-block">
          <div class="row">
           @foreach(array_keys($ranks) as $rank)
             @foreach($staffs->where('rank', $rank) as $member)
               <div class="col-lg-2 col-xl-2 col-md-6 col-sm-6 col-6" style="margin: auto;">
                 <div class="staff-block">
                   <div class="img-staff">
                     <img src="https://crafatar.com/renders/head/{{$member->uuid}}?scale=5" alt="">
                   </div>
                   <div>
                     <h5>[<span style=" color: {{ $ranks[$member->rank]}};">{{$member->rank}}</span>]</h5>
                     <span>{{ $member->pseudo }}</span>
                   </div>
                 </div>
               </div> 
             @endforeach
           @endforeach
          </div>
        </section>
    </section>
@endsection
