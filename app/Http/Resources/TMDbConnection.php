<?php

namespace App\Http\Resources;

class TMDbConnection
{
    private $_url;

    private $_key;

    public function __construct()
    {
        $this->_url = env('TMDbURL');
        $this->_key = env('TMDbKEY');
    }

    public function search($keyword, $adult = false): \stdClass
    {
        //build search string
        $keyword = trim($keyword);
        $keyword = urlencode($keyword);
        $searchUrl = $this->_url.
            "search/movie?query={$keyword}&include_adult={$adult}&language=en-US&page=1";

        //Create Connection
        $client = new \GuzzleHttp\Client;

        $response = $client->request(
            'GET',
            $searchUrl,
            [
                'headers' => [
                    'Authorization' => $this->_key,
                    'accept' => 'application/json',
                ],
            ]
        );

        return json_decode($response->getBody());
    }

    public function singleMovieData($id): \stdClass
    {
        $movieUrl = $this->_url."movie/{$id}?language=en-US";

        //Create Connection
        $client = new \GuzzleHttp\Client;
        $response = $client->request(
            'GET',
            $movieUrl,
            [
                'headers' => [
                    'Authorization' => $this->_key,
                    'accept' => 'application/json',
                ],
            ]
        );

        return json_decode($response->getBody());
    }

    public function getWatchProviders($tmdb_id): \stdClass
    {
        $movieUrl = $this->_url."movie/{$tmdb_id}/watch/providers";
        //Create Connection
        $client = new \GuzzleHttp\Client;
        $response = $client->request(
            'GET',
            $movieUrl,
            [
                'headers' => [
                    'Authorization' => $this->_key,
                    'accept' => 'application/json',
                ],
            ]
        );

        return json_decode($response->getBody());
    }

    public function getProviders(): \stdClass
    {
        $movieUrl = $this->_url.'watch/providers/movie?language=en-US&watch_region=US';
        //Create Connection
        $client = new \GuzzleHttp\Client;
        $response = $client->request(
            'GET',
            $movieUrl,
            [
                'headers' => [
                    'Authorization' => $this->_key,
                    'accept' => 'application/json',
                ],
            ]
        );

        return json_decode($response->getBody());
    }
}
