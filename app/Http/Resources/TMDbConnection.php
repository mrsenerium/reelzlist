<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Guzzelhttp\Guzzle;
Use App\Models\Movie;

class TMDbConnection
{
    private $url;
    private $key;

    public function __construct() {
        $this->url = env('TMDbURL');
        $this->key = env('TMDbKEY');
    }
    /**
     * This function does a search of TMDb.com
     * 
     * @params $keyword
     * @returns stdClass
     */
    public function search($keyword, $adult = false) : \stdClass {
        //build search string
        $keyword = trim($keyword);
        $keyword = urlencode($keyword);
        $searchUrl = $this->url . "search/movie?query=$keyword&include_adult=$adult&language=en-US&page=1";

        //Create Connection
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $searchUrl, [
        'headers' => [
            'Authorization' => $this->key,
            'accept' => 'application/json',
        ],
        ]);

        return json_decode($response->getBody());
    }

    public function single_movie_data($id)
    {
        $movieUrl = $this->url . "movie/$id?language=en-US";

        //Create Connection
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $movieUrl, [
            'headers' => [
                'Authorization' => $this->key,
                'accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody());
    }
}
