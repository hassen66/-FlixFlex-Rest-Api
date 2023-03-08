<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $url = "https://api.themoviedb.org/3/tv/popular?api_key=".env('TMDB_API_KEY')."&page=".$page;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $series = json_decode(curl_exec($ch),true);
        curl_close($ch);

        

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $series
        ]);

    }

    public function getTopRated(Request $request){
        $url = "https://api.themoviedb.org/3/tv/top_rated?api_key=".env('TMDB_API_KEY');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $series = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => array_slice($series['results'], 0, 5, true)
        ]);
    }

    public function search(Request $request){
        $page = $request->page ? $request->page : 1;
        $url = "https://api.themoviedb.org/3/search/tv?api_key=".env('TMDB_API_KEY')."&page=".$page."&query=".$request->q;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $series = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $series['results']
        ]);
    }

    public function getTrailer(Request $request, $id){
        $url = "https://api.themoviedb.org/3/tv/".$id."/videos?api_key=".env('TMDB_API_KEY');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $movie = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $movie
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $url = "https://api.themoviedb.org/3/tv/".$id."?api_key=".env('TMDB_API_KEY');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $serie = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $serie
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
