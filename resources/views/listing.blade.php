@extends('layout')

@section('content')
@include('partials._hero')

<h2>{{$listing['title']}}</h2>
<p>{{ $listing['description']}}</p>


@endsection