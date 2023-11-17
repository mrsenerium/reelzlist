<?php

namespace App\Http\Resources;

class OMDbConnection
{
    private $_url;
    private $_key;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_url = env('OMDbURL');
        $this->_key = env('OMDbKEY');
    }

    /**
     * This function does a search of TMDb.com
     *
     * @param $imdb_key Key shared by IMDB
     * @return stdClass
     */
    public function getSingleMovie($imdb_key): \stdClass
    {

        $key = $this->_url . '?i=' . $imdb_key . '&r=json&apikey=' . $this->_key;
        //Create Connection
        $client = new \GuzzleHttp\Client();

        $response = $client->get($key);
        //$response = json_decode($response->getBody());
        //echo '<pre>';
        //var_dump($response);die('</pre>');

        return json_decode($response->getBody());
    }
}
