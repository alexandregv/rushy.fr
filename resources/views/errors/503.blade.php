@extends('errors.default')

@section('error', "Maintenance")

@section('message')
  @if($exception->getMessage())
      {{ $exception->getMessage() }}
  @else
      Nous revenons dans quelques instants...
  @endif
@endsection