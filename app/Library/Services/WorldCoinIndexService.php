<?php

namespace App\Library\Services;
use App\Library\Services\Base\BaseService;

use App\WorldCoinIndex;

class WorldCoinIndexService extends BaseService{

    public function get(){

        $params = [
            'key'  => env('WORLD_COIN_INDEX_KEY'),
            'fiat' => 'btc',
        ];
        $response = $this->retrieveData(env('WORLD_COIN_INDEX'), $params);

        WorldCoinIndex::truncate();
        foreach ($response as $index => $data){
            WorldCoinIndex::create($data);
        }
    }

}