<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Guzzelhttp\Guzzle;
Use App\Models\Movie;

class OMDbConnection
{
    private $url;
    private $key;

    public function __construct() {
        $this->url = env('OMDbURL');
        $this->key = env('OMDbKEY');
    }
    /**
     * This function does a search of TMDb.com
     * 
     * @params $keyword
     * @returns stdClass
     */
    public function search($imdb_key) : \stdClass {

        $key = $this->url . "?i=" . $imdb_key . "&r=json&apikey=" . $this->key;
        //Create Connection
        $client = new \GuzzleHttp\Client();
        
        $response = $client->get($key);
        //$response = json_decode($response->getBody());
        //echo '<pre>';
        //var_dump($response);die('</pre>');

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