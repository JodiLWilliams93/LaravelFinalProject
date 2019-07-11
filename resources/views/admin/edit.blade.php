@extends('layouts.master')

@section('content')
    <h1>Edit post {{$climb['id']}}</h1>
    @include('partials.climb-form')
@endsection