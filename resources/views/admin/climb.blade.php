@extends('layouts.master')

@section('content')
    <ul>
        @foreach ($climb as $key=>$value)
        <li>
            @if ($key != 'view_climb')
                {{ $key }}: {{ $value }}
            @else
                {{ $key }}: <a href="{{ $value['href'] }}">View Climb</a>
            @endif
        </li>
        @endforeach
    </ul>
@endsection