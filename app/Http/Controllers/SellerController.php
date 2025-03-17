<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SellerController extends Controller
{
    public function index()
    {
        if (!auth()->check() || (!auth()->user()->hasRole('Penjual') && !auth()->user()->hasRole('Admin'))) {
            abort(403, 'Unauthorized Access');
        }

        $posts = Post::where('user_id', auth()->id())->get();

        return view('seller.seller-manage-posts', compact('posts'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            if (!auth()->check() || !auth()->user()->hasRole('Penjual')) {
                abort(403, 'Unauthorized Access');
            }

            return view('seller.seller-create-post');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'stock' => 'required|integer|min:0',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                try {
                    $imagePath = $request->file('image')->store('images', 'public');
                } catch (\Exception $e) {
                    return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()])->withInput();
                }
            }

            try {
                Post::create([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                    'stock' => $validated['stock'],
                    'user_id' => auth()->id(),
                    'image' => $imagePath,
                ]);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
            }

            return redirect()->route('seller.index')->with('success', 'Post berhasil dibuat!');
        }

        return abort(405, 'Metode HTTP tidak didukung.');
    }
}
