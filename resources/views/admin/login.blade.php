@extends('admin.default')


@section('content')

 <form method="POST" action="{{ action('AdminController@login') }}">
  @csrf
  <div class="card" style="width: 21.5rem; margin: 350px auto 0 auto;">
    <div class="card-header">
      Accès administrateur
    </div>
    <div class="card-body">
      <div class="form-group">
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
      </div>
      {!! app('captcha')->display($attributes = [], $options = ['lang'=> 'fr']) !!}
      <button type="submit" class="btn btn-primary mt-2">Connexion</button>
    </div>
  </div>
</form>

@endsection
