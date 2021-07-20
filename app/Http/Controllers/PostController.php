<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ambil data dari tabel posts
        $posts = Post::latest()->get();

        // kembalikan response berupa JSON
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Post',
            'data'      => $posts
        ], 200);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);


        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // simpan ke database
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        // respon jika data berhasil disimpan
        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Post Created',
                'data'      => $post,
            ], 201);
        }

        // respon jika data gagal disimpan
        return response()->json([
            'success'   => false,
            'message'   => 'Post Failed to Save',
        ], 409);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // cari data post by ID
        $post = Post::findOrFail($id);

        // buat response berupa JSON
        return response()->json([
            'success'   => true,
            'message'   => 'Detail Data Post',
            'data'      => $post,
        ], 200);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // cari data post by ID
        $post = Post::findOrFail($post->id);

        if ($post) {
            //update post
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);


            // buat response sukses berupa JSON
            return response()->json([
                'success'   => true,
                'message'   => 'Post Updated',
                'data'      => $post,
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cari data post by ID
        $post = Post::findOrFail($id);

        if ($post) {
            // hapus data post
            $post->delete();

            // buat response sukses berupa JSON
            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }

        // buat response gagal berupa JSON
        return response()->json([
            'success'   => false,
            'message'   => "Post Not Found",
        ], 404);
    }
}
