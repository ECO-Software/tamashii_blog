<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)->paginate(8);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $related = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('id')
            ->take(4)
            ->get();
        return view('posts.show', compact('post', 'related'));
    }

    public function category(Category $category)
    {
        $posts = Post::where('category_id', $category->id)->where('status', 1)->latest('id')->paginate(5);
        return view('posts.category', compact('posts', 'category'));
    }

    public function tag(Tag $tag)
    {
       $posts = $tag->posts()->where('status', 1)->latest('id')->paginate(5);
        return view('posts.tag', compact('posts', 'tag'));
    }

}
