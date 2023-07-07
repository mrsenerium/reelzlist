<?php
/**
 * TMDbConnection
 *
 * PHP version 8.1
 *
 * @category API_Connector
 * @package  API_Connector
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Guzzelhttp\Guzzle;
Use App\Models\Movie;

/**
 * TMDbConnection
 *
 * @category API_Connector
 * @package  API_Connector
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
class TMDbConnection
{
    private $_url;
    private $_key;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_url = env('TMDbURL');
        $this->_key = env('TMDbKEY');
    }

    /**
     * This function does a search of TMDb.com
     *
     * @param $keyword Will be search TMDb.com
     * @param $adult   Allows searching for adult films
     *
     * @return stdClass
     */
    public function search($keyword, $adult = false) : \stdClass
    {
        //build search string
        $keyword = trim($keyword);
        $keyword = urlencode($keyword);
        $searchUrl = $this->_url .
            "search/movie?query=$keyword&include_adult=$adult&language=en-US&page=1";

        //Create Connection
        $client = new \GuzzleHttp\Client();

        $response = $client->request(
            'GET', $searchUrl, [
            'headers' => [
                'Authorization' => $this->_key,
                'accept' => 'application/json',
            ],
            ]
        );

        return json_decode($response->getBody());
    }

    /**
     * Pulls individual data from TMDB.com
     *
     * @param $id The TMDB id of the movie
     *
     * @return stdClass
     */
    public function singleMovieData($id) : \stdClass
    {
        $movieUrl = $this->_url . "movie/$id?language=en-US";

        //Create Connection
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET', $movieUrl, [
            'headers' => [
                'Authorization' => $this->_key,
                'accept' => 'application/json',
            ],
            ]
        );

        return json_decode($response->getBody());
    }

    /**
     * Finds where it can be streamed
     *
     * @param $tmdb_id TMDb id
     *
     * @return stdClass
     */
    public function getWatchProviders($tmdb_id) : \stdClass
    {
        $movieUrl = $this->_url . "movie/$tmdb_id/watch/providers?language=en-US";
        //Create Connection
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET', $movieUrl, [
            'headers' => [
                'Authorization' => $this->_key,
                'accept' => 'application/json',
            ],
            ]
        );
        return json_decode($response->getBody());
    }
}
