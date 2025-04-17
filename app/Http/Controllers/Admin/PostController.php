<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $posts = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->slug =  Str::slug($request->title);
        $post->category = $request->category;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename); 
            $post->image = 'uploads/' . $filename; 
        }
    
        $post->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'image_url' => asset($post->image),
        ]);

    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category = $request->category;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename);
            $post->image = 'uploads/' . $filename;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
            'image_url' => asset($post->image),
        ]);
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!',
        ]);
    }

}
