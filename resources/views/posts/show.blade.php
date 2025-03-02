

@extends('layouts.app')

@section('content')
    

    <a href="/posts" class="btn btn-default">Go back</a>

    <h1>{{$post->title}}</h1>
    <div>
        {!! $post->body !!}
    </div>
    <small> Written on {{$post->created_at}}</small>

    @if(!Auth::guest() && Auth::user()->id === $post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => "POST", 'class' => "pull-right"]) !!}
            {{Form::hidden('_method', "DELETE")}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!! Form::close() !!}
    @endif; 

@endsection 