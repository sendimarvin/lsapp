

@extends('layouts.app')

@section('content')
    <h1>Your posts</h1>


    @if(count($posts) === 0)
        <p>There are no posts available</p>
    @else
        
        @foreach($posts as $index => $post)
            <div class="well">

                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img src="width:100%" alt="" src="/storage/cover_images/{{$post->cover_image}}">
                        <br><br>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="posts/{{$post->id}}" >{{$post->title}}</a></h3>
                        <p>{!! $post->body !!}</p>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>

                
            </div>
        @endforeach

        {{$posts->links()}}
        
    @endif

@endsection 