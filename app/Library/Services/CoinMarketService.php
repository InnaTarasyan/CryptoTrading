<?php

namespace App\Library\Services;

use App\Coinmarketcap;
use App\Library\Services\Base\BaseService;

class CoinMarketService extends  BaseService {

    public function get(){

        $params = [
            'limit' => 0
        ];
        $response = $this->retrieveData(config('coinmarketcap.url'), $params);

        Coinmarketcap::truncate();

        foreach ($response as $data){
            $data['native_id'] = $data['id'];
            Coinmarketcap::create($data);
        }

    }
}
