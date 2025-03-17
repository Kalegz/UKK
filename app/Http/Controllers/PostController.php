<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with('user')->get();

        return view('posts', compact('posts'));
    }

    /**
     * Reduce stock of the post.
     */
    public function reduceStock(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $post = Post::findOrFail($id);

        if ($post->stock >= $validated['quantity']) {
            $post->stock -= $validated['quantity'];
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Stok berhasil dikurangi!');
        }

        return redirect()->route('posts.index')->with('error', 'Stok tidak mencukupi!');
    }
}
