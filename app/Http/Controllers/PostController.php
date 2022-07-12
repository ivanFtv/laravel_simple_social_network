<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;




class PostController extends Controller
{
    public function create() 	
    {              	
        return view('posts.create');      	
    }

    public function profile() 	
    {              	
        return view('profile')->with('posts', Post::all());	
    }
}