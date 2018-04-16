<?php

namespace App\Library\Services;

use App\Coindar;
use App\Library\Services\Base\BaseService;

class CoindarService extends  BaseService {

    public function get(){

        $response = $this->retrieveData(config('coindar.url'), []);

        Coindar::truncate();
        foreach ($response as $data){
            Coindar::create($data);
        }
    }
}