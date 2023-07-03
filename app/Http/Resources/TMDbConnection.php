<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Guzzelhttp\Guzzle;

class TMDbConnection extends JsonResource
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
    public function search($keyword) : \stdClass {
        //Create Connection
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $this->url, [
        'headers' => [
            'Authorization' => $this->key,
            'accept' => 'application/json',
        ],
        ]);
        //var_dump($response);die();

        return json_decode($response->getBody());
    }
}
