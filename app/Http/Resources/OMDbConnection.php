<?php

namespace App\Http\Resources;

class OMDbConnection
{
    private $_url;

    private $_key;

    public function __construct()
    {
        $this->_url = env('OMDbURL');
        $this->_key = env('OMDbKEY');
    }

    public function getSingleMovie($imdb_key): \stdClass
    {

        $url = $this->_url.'?i='.$imdb_key.'&r=json&apikey='.$this->_key;
        $client = new \GuzzleHttp\Client;
        $response = $client->get($url);

        return json_decode($response->getBody());
    }
}
