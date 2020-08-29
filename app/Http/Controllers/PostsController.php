<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
    	$posts = Post::latest()->get();

    	return response([
    		'success' => true,
    		'message' => 'List Semua Posts',
    		'data' => $posts
    	], 200);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required',
    		'content' => 'required'
    	], 
    	[
    		'title.required' => 'Masukkan Title Post',
    		'content.required' => 'Masukkan Content Post'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Silakan Isi Data yang Kosong',
    			'data' => $validator->errors()
    		], 400);
    	} else {
    		$post = Post::create($request->only('title', 'content'));

    		if ($post) {
    			return response()->json([
    				'success' => true,
    				'message' => 'Post Berhasil',
    			], 200);
    		} else {
    			return response()->json([
    				'success' => false,
    				'message' => 'Post Gagal Disimpan',
    			], 400);
    		}
    	}
    }

    public function show($id)
    {
    	$post = Post::whereId($id)->first();

    	if ($post) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Detail Post',
    			'data' => $post
    		], 200);
    	} else {
    		return response()->json([
    			'return' => false,
    			'message' => 'Post Tidak Berhasil',
    			'data' => ''
    		], 404);
    	}
    }

    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required',
    		'content' => 'required',
    	], 

    	[
    		'title.required' => 'Masukkan Title Post',
    		'content.required' => 'Masukkan Content Post'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Silakan Isi Data yang Kosong',
    			'data' => $validator->errors()
    		], 400);
    	} else {
    		$post = Post::whereId($request->input('id'))->update($request->only('title', 'content'));

    		if ($post) {
    			return response()->json([
    				'success' => true,
    				'message' => 'Post Berhasil diupdate',
    			], 200);
    		} else {
    			return response()->json([
    				'success' => false,
    				'message' => 'Post Gagal diupdate',
    			], 500);
    		}
    	}
    }

    public function destroy($id)
    {
    	$post = Post::findOrFail($id);
    	$post->delete();

    	if ($post) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Post Berhasil dihapus',
    		], 200);
    	} else {
    		return response()->json([
    			'success' => false,
    			'message' => 'Post Gagal dihapus'
    		], 500);
    	}
    }
}
