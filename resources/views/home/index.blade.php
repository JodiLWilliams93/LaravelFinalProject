@extends('layouts.master')

@section('content')
<h1>Climbs</h1>
<ul>
    @foreach ($climbs['climbs'] as $climb)
    <li>
        {{ $climb['name'] }}, {{ $climb['location']}}
        <a href="{{ route('home.climb', ['id' => $climb['id']]) }}">More</a>
    </li>
    @endforeach
</ul>
@endsection