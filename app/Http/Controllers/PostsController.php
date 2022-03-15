<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(){
        $posts = DB::table('post')->get();
        return response([
            'success' => true,
            'message' => 'List Semua Posts',
            'data' => $posts
        ], 200);
    }
    public function store(Request $request){
        //validate data
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'teks'   => 'required',
        ],
            [
                'judul.required' => 'Mohon masukkan Title Post !',
                'teks.required' => 'Mohon masukkan Content Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = DB::table('post')->create([
                'judul'     => $request->input('judul'),
                'teks'   => $request->input('teks')
            ]);


            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        }
    }
    public function show($id){
        $post = DB::table('post')->whereId($id)->first();
        if($post){
            return response()->json([
                'success' => true,
                'message' => 'Detail Posts!',
                'data' => $post
            ], 200);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Detail Posts tidak ditemukan!',
                'data' => ''
            ], 404);
        }
    }
    public function update(Request $request){
         //validate data
         $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'teks'   => 'required',
        ],
            [
                'judul.required' => 'Masukkan Title Post !',
                'teks.required' => 'Masukkan Content Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = DB::table('post')->create([
                'judul'     => $request->input('judul'),
                'teks'   => $request->input('teks')
            ]);


            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate!',
                ], 500);
            }
        }
    }
    public function destroy($id){
        $post = DB::table('post')->whereId($id)->delete();

        if($post){
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Post Gagal Dihapus!',
            ], 500);
        }
    }
}
