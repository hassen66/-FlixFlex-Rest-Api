<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CodeBugLab\Tmdb\Facades\Tmdb;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=".env('TMDB_API_KEY')."&page=".$page;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $movies = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $movies['results']
        ]);

    }

    public function getTopRated(Request $request){
        $url = "https://api.themoviedb.org/3/movie/top_rated?api_key=".env('TMDB_API_KEY');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $movies = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => array_slice($movies['results'], 0, 5, true)
        ]);
    }

    public function search(Request $request){
        $page = $request->page ? $request->page : 1;
        $url = "https://api.themoviedb.org/3/search/movie?api_key=".env('TMDB_API_KEY')."&page=".$page."&query=".$request->q;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        $movies = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => $movies['results']
        ]);
    }

    public function getTrailer(Request $request, $id){
        $url = "https://api.themoviedb.org/3/movie/".$id."/videos?api_key=".env('TMDB_API_KEY');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $url = "https://api.themoviedb.org/3/movie/".$id."?api_key=".env('TMDB_API_KEY');
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
}
