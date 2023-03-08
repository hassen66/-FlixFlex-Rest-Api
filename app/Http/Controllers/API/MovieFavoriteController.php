<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieFavoriteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,$movieId)
    {
        $favorite = Favorite::firstOrCreate([
            'ref_id' => $movieId,
            'user_id' => $request->user()->id,
            'type' => 'movie'
        ]);

        return response()->json([
            'statusCode' => Response::HTTP_CREATED,
            'status' => Response::$statusTexts[Response::HTTP_CREATED],
            'data' => $favorite
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,$movieId,$id)
    {
        $favorite = Favorite::where('id',$id)->where('type','movie')->where('user_id',$request->user()->id)->first();

        if($favorite){
            $favorite->delete();
        }

        return response()->json([
            'statusCode' =>  Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'message' => 'Item has been removed',
        ], Response::HTTP_OK);
    }
}
