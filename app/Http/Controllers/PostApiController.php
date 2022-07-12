<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Mail\PostMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;


class PostApiController extends Controller
{


    public function index() 
    {
        return Post::orderBy('created_at', 'DESC')->with('user')->get();
    }

    
    public function store(Request $request)
    {
        $post = new Post;
        $request->validate([
            'photo' => 'image:jpeg,png,jpg|max:2048',
            'description' => 'required|min:4'
        ]);
        $post->user_id = $request->user_id;

        if ($request->file('photo')) {
            $name = uniqid() . '.' . $request->photo->extension();
            $request->photo->move(public_path('post_images'), $name);
            $post->photo = $name;
        }
        
        $post->description = $request->description;
        $post->save();
        
        Mail::to($request->email_id)->send(new PostMail($post));

        return ['success' => 'Post created successfully.'];
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'description' => 'required|min:4'
        ]);
        $post->description = $request->description;
        $post->save();

        return ['success' => 'Post edited successfully.'];
    }


        
    public function user() 	
    {  	
        return $this->belongsTo('App\Models\User'); 	
    }



    public function destroy(Post $post) 	{     	
        $postImage = 'post_images/' . $post->photo;
        if(File::exists($postImage)) {
            File::delete($postImage);
        }	
        $post->delete();
        return ['success' => 'Post deleted successfully.'];  	
    }

}
