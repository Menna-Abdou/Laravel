@extends('Layouts.app')

@section('title') View @endsection

@section('content')
<div class="card bg-light mt-5" >
  <div class="card-header">Post Info</div>
  <div class="card-body">
    <h5 class="card-title" style="font-size:18px;display:inline;">Title</h5>
    <p class="card-text" style="display:inline;"> {{$post['title']}}</p>
    <h5 class="card-title mt-4" style="font-size:18px">Description</h5>
    <p class="card-text"> {{$post['description']}}</p>
  </div>
</div>
<!-- //------------------------------------------------------------------------------------------ -->
<!-- post creator info ---------------------------------------------------------------------------->
<div class="card my-4">
    <div class="card-header fw-bold fs-1">
        Post Creator info
    </div>
    <div class="card-body ">
        <h5 class="card-title fs-4">
            <span class="fw-bold">Name:</span>
            <p class="d-inline-block card-text text-muted">
                {{$post->user ? $post->user->name : 'Not Found'}}
            </p>
        </h5>
        <h5 class="card-title fs-4">
            <span class="fw-bold">Email:</span>
            <p class="d-inline-block card-text text-muted">
                {{$post->user ? $post->user->email : 'Not Found'}}
            </p>
        </h5>
        <h5 class="card-title fs-4">
            <span class="fw-bold">Created At:</span>
            <p class="d-inline-block card-text text-muted">
                {{$post['created_at']->toDayDateTimeString()}}
            </p>
        </h5>
        <h5 class="card-title fs-4">
                <span class="fw-bold">Slug:</span>
                <p class="d-inline-block card-text text-muted">
                    {{$post->slug}}
                </p>
            </h5>
       @if($post->image)
                <div style="width:300px">
                <img width="100%" src="{{ asset('images/'.$post->image) }}" alt={{$post->title."image"}} />
                </div>
        @endif
    </div>
</div>
<!-- //------------------------------------------------------------------------ -->
<!-- comments ----------------------------------------------------------------------->
<h1>Comments</h1>
<div>
    <form method="POST" action="{{route('comments.create' , ['postId' => $post['id']])}}">
        @csrf
        <input class="form-control form-control-lg" type="text" placeholder="add comment" name="comment" >
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
</div>
<div class='mt-4 text-dark'>
@if($post->comments)
    @foreach ($post->comments as $comment)
    <div class='my-4 border p-4'>
        <h3 class='text-lg fw-bold'>{{$comment->user->name}}</h3>
        <p class='text-lg my-2 fs-2'>{{$comment->body}}</p>
        <span class='text-sm'>Last Updated At: {{$comment->updated_at->toDayDateTimeString()}}</span>
        <div class="mt-4  flex">
            <form class="text-center d-inline" method='POST' action="{{route('comments.delete', ['postId' => $post['id'], 'commentId' => $comment->id])}}">
                @csrf
                @method('DELETE')
                <button type="sumbit" class='btn btn-lg btn-primary'>Delete</button>
            </form>
            <a class='btn btn-lg btn-primary ml-4' href="{{route('comments.view', ['postId' => $post['id'], 'commentId' => $comment->id])}}">
                Edit
            </a>
        </div>
    </div>
    @endforeach
@endif
</div>
<div class="my-3">
    <a href="{{route('posts.index')}}" class="btn btn-primary btn-lg">Back</a>
</div>

  @endsection
