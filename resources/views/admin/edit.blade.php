@extends('layouts.master')

@section('content')
<h1>Edit {{$climb['name']}}</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="/admin/climb/{{ $climb['id'] }}/edit" method="post">
    @include('partials.climb-form')
    <div class="form-group">
        <input type="submit" value="Update Route">
    </div>
    <!--end .form-group -->
</form>
@endsection