<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function store(Request $request){
           //validate data
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'teks'   => 'required',
        ],
            [
                'judul.required' => 'Masukkan judul Post !',
                'teks.required' => 'Masukkan teks Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $post = DB::table('post')->insert([
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
                ], 401);
            }
        }
    }
}
