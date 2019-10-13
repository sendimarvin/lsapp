

@extends('layouts.app')


@section('content')
    <h1>Welcome to the services page</h1>


    <h1>Services offered include: </h1>



    @if(count($services) > 0)
        <ul class="list-group">
            @foreach ($services as $item)
                <li class="list-group-item">{{$item}}</li>
            @endforeach

        </ul>

    @else
        <p class="alert alert-warning">There are no services to offer</p>
    @endif

@endsection
