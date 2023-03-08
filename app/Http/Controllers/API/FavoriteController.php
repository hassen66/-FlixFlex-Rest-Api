<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $favorites = Favorite::orderByDesc('created_at')->orderByDesc('id')->paginate(15);

        $favorites->getCollection()->transform(function ($favorite) {
            // Your code here
            if($favorite->type == 'movie'){
                $url = "https://api.themoviedb.org/3/movie/".$favorite->ref_id."?api_key=".env('TMDB_API_KEY');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_REFERER, 1);
                $data = json_decode(curl_exec($ch),true);
                curl_close($ch);
            }
            else{
                $url = "https://api.themoviedb.org/3/tv/".$favorite->ref_id."?api_key=".env('TMDB_API_KEY');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_REFERER, 1);
                $data = json_decode(curl_exec($ch),true);
                curl_close($ch);
            }
            $favorite->ref = $data;
            return $favorite;
        });

        $favorites = $favorites->items();

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $favorites,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,$movieId)
    {
        $favorite = Favorite::create([
            'ref_id' => $movieId,
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
    public function destroy($movieId,$id)
    {
        $favorite = Favorite::where('id',$id)->where('type','movie')->first();

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
