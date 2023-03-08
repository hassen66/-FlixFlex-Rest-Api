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
    public function index(Request $request)
    {
        $favorites = Favorite::where('user_id',$request->user()->id)->orderByDesc('created_at')->orderByDesc('id')->paginate(15);

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
}
