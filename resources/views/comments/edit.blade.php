@extends('layouts.app')

@section('title')edit in comment @endsection

@section('content')
<!-- <div>
    <h2>Title : {{$post['title']}}</h2>
    <h2>User :{{$post->user ? $post->user->name : 'Not Found'}}</h2>
    <h2>Created At: {{\Carbon\Carbon::parse($post['created_at'])->format('M-d-Y');}}</h2>
    <h2 >Description:{{$post['description']}}</h2>
</div> -->
<div>
<h1>All Comments</h1>
    @foreach ($post->comments as $coment)
    <div class='my-4 border p-4'>
        <h2 class='text-lg fw-bold'>User:{{$coment->user->name}}</h2>
        <p class='text-lg my-2 fs-2'>Body:{{$coment->body}}</p>
        <p class='text-sm '>updated at: {{$coment->updated_at->toDayDateTimeString()}}</p>
        <div class="mt-4">
            <form class="text-center d-inline" method='POST' action="{{route('comments.delete', ['postId' => $post['id'], 'commentId' => $coment->id])}}">
                @csrf
                @method('DELETE')
                <button type="submit" class='btn btn-primary'>Delete</button>
            </form>
            <a class='btn btn-primary ml-4' href={{route('comments.view', ['postId' => $post['id'], 'commentId' => $coment->id])}}>
                Edit
            </a>
        </div>
    </div>
    @endforeach
    <div class='flex flex-col mt-6  p-4 rounded-lg'>
        <form method="POST" action={{route('comments.update', ['postId' => $post['id'], 'commentId' => $comment->id])}}>
            @csrf
            @method('PATCH')
            <label class="form-label fs-2">Edit comment</label>
            <input class="form-control form-control-lg" type="text" placeholder="Edit comment" value={{$comment["body"]}} name="comment" id="coment" >
            <button type="submit" class="btn btn-primary mt-3">Edit comment</button>
        </form>
    </div>
</div>
@endsection
