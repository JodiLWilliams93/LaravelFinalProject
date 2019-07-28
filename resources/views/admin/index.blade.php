@extends('layouts.master')

@section('content')
<h1>Admin Homepage</h1>
<div class="mt-4">
    <a class="btn btn-success" href="{{ route('admin.create') }}">Create Climb</a>
    <br>
</div>
<div class="mt-3">
    @foreach ($climbs['climbs'] as $climb)
    <li>
        {{ $climb['name'] }}
        <a href="{{ route('admin.climb', ['id' => $climb['id']]) }}">View</a>
        <a href="{{ route('admin.edit', ['id' => $climb['id']]) }}">Edit</a>
        <a href="{{ route('admin.delete', ['id' => $climb['id']]) }}">Delete</a>
    </li>
    @endforeach
</div>

@endsection