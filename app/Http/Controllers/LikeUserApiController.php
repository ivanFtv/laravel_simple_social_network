<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikeUserApiController extends Controller
{


    public function store(Request $request)
    {
    
        $data = $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'users_username' => 'required'
        ]);
       
        $like = Like::where('post_id', $data['post_id'])
            ->where('users_id', $data['user_id'])
            ->first();

        if ($like) {
            $like->delete();
            return ['deleted' => 'Like deleted.'];
        } else {
            $like = new Like;
            $like->post_id = $data['post_id'];
            $like->users_id = $data['user_id'];
            $like->users_username = $data['users_username'];
            $like->save();         

            Post::find($data['post_id'])->likes()->attach(Like::find($like->id));
        }

        return ['added' => 'Like adding successful.'];
    }

    public function show($id) {
        $likes = Like::where('post_id', '=', $id)->get('users_username');
        return ['likes' => $likes];
    }

}
