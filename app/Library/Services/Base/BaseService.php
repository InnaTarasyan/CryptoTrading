<?php

namespace App\Library\Services\Base;

use GuzzleHttp;

class BaseService{

    public function retrieveData($url, $params){
        $client = new GuzzleHttp\Client();

        $response = json_decode($client->get(
            $url,
            [
                'query' => $params
            ]
        )->getBody(), true);

        return $response;
    }
}