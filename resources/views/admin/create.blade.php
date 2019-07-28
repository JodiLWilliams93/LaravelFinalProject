@extends('layouts.master')

@section('content')
<h1>Create New Climb</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="/admin/create" method="post">
    @include('partials.climb-form')
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" value="{{ old('location', '') }}">
    </div>
    <div class="form-group">
        <label for="public">Public</label>
        Yes
        <input type="radio" name="public" id="public1" value="1">
        No
        <input type="radio" name="public" id="public0" value="0" checked>
    </div>
    <div class="form-group">
        <input type="submit" value="Create Route">
    </div>
    <!--end .form-group -->
</form>
@endsection