<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Str;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index(){
    $posts =Post::all();
    // return new PostResource($posts);
        return PostResource::collection($posts);
    }
// --------------------------------------------------------------
    public function show($id){
    $post= Post::find($id);
        return new PostResource($post);
    }
// --------------------------------------------------------------
    public function store(StorePostRequest $request){
    if ($request->hasFile('image')) {
        $destination='public/images';
        $image=$request->file('image');
        $image_name=$image->getClientOriginalName();
        $path=$request->file('image')->storeAs($destination,$image_name);
        }
        //---------------------
        $insertedData=request()->all();
        $post = Post::create([
            'title'=>$insertedData['title'],
            'description'=>$insertedData['description'],
            'user_id'=>$insertedData['post_creator'],
            'slug' => Str::of($insertedData['title'])->slug('-'),
            // 'image'=>$image_name,
        ]);
        // $request->image->move(public_path('images'), $image_name);
            return new PostResource($post);
    }
}
