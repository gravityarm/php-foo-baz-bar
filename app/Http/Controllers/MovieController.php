<?php

namespace App\Http\Controllers;

use External\Bar\Exceptions\ServiceUnavailableException;
use External\Bar\Movies\MovieService;
use External\Baz\Movies\MovieService as MoviesMovieService;
use External\Foo\Movies\MovieService as FooMoviesMovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTitles(Request $request): JsonResponse
    {

        try {
            $barService = new MovieService();
            $bazService = new MoviesMovieService();
            $fooService = new FooMoviesMovieService();
            

            $barMovie = $barService->getTitles();
            $bazMovie = $bazService->getTitles();
            $fooMoive = $fooService->getTitles();
            
    
            $barTitle = [];
            foreach ($barMovie['titles'] as $movie) {
                foreach($movie as $key => $val) {
                    if ($key === 'title') {
                        $barTitle[] = $val;
                    }
                }
            }
            $bazTitle = $bazMovie['titles'];
            $fooTitle = $fooMoive;

            $allTitle = array_merge($barTitle, $bazTitle, $fooTitle);


            return response()->json($allTitle);

            
        } catch(ServiceUnavailableException $e) {
            $e->getMessage();
        }
        
        
        return response()->json([]);

    }
}
