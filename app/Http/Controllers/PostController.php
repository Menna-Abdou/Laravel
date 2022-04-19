<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller{
    public function index(){
        // $posts=Post::all();
        // $posts=Post::with('user')->get();

        $posts = Post::paginate(5);
       return view('posts.index',['allPosts'=>$posts]);
    }
//----------------------------------------------------------------------
    public function create(){
    $users=User::all();
        return view('posts.create',['users'=>$users]);
    }
//----------------------------------------------------------------------
    public function store(StorePostRequest $request){
    // public function store(Request $request){
    // $request->validate([
    //     'title'=>['required','min:3','unique:posts'],
    //     'description'=>['required','min:10'],
    //     // 'image'=>['required','mimes:jpg,png']
    //     ],[
    //     'title.required'=>"Title is Required",
    //     'title.min'=>"Title must be more than 3",
    //     'title.unique'=>"Title must be unique",
    //     'description.required'=>"Description is Required",
    //     'description.min'=>"Description must be at least 10 characters"
    //     ]
    // );
//---------------------
    if ($request->hasFile('image')) {
        // $filename =$request->image->getClientOriginalName();
        // dd($filename);
        // $request->image->storeAs('images', $filename,'public');
        //----------------
        $destination='public/images';
        $image=$request->file('image');
        $image_name=$image->getClientOriginalName();
        $path=$request->file('image')->storeAs($destination,$image_name);
        }
//---------------------
        $insertedData=request()->all();
        post::create([
        'title'=>$insertedData['title'],
        'description'=>$insertedData['description'],
        'user_id'=>$insertedData['post_creator'],
        'slug' => Str::of($insertedData['title'])->slug('-'),
        // 'image'=>$filename,
        'image'=>$image_name,
        ]);
        $request->image->move(public_path('images'), $image_name);
         return redirect()->route('posts.index');
    }
//----------------------------------------------------------------------
    public function show($id) {
        // $dbPost=Post::findOrFail($id);
        $dbPost=Post::where('id',$id)->first();
        // dd($dbPost);
        return view('posts.show',[
            'post'=>$dbPost
        ]);
    }
//----------------------------------------------------------------------
    public function edit($id){
        $users=User::all();
        $post=Post::where('id',$id)->first();
        // dd($post);
        return view('posts.edit',['post'=>$post,'users'=>$users]);
    }
//----------------------------------------------------------------------
    // public function update(Request $request,$id,StorePostRequest $reques){
        public function update(Request $request,$id){
        request()->validate([
            'title'=>['required','min:3','unique:posts'],
            'description'=>['required','min:10']
            ],[
            'title.required'=>"Title is Required",
            'title.min'=>"Title must be more than 3",
            'title.unique'=>"Title must be unique",
            'description.required'=>"Description is Required",
            'description.min'=>"Description must be at least 10 characters"
            ]
        );
    //---------------------
        $postToUpdate = post::find($id);
        $postToUpdate->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator,
            'slug' => Str::of($request['title'])->slug('-'),
        ]);

        return  redirect()->route('posts.index');
    }
//----------------------------------------------------------------------
    public function destroy ($id){
        $post = Post::where('id', $id);
        $com= Comment::where('commentable_id',$id);
        $com->delete();
        $post->delete();
           return redirect()->route('posts.index');
       }
}
