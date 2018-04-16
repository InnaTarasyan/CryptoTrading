<?php

namespace App\Library\Services;
use App\Library\Services\Base\BaseService;

use App\WorldCoinIndex;

class WorldCoinIndexService extends BaseService{

    public function get(){

        $params = [
            'key' => config('worldcoinindex.key')
        ];
        $response = $this->retrieveData(config('worldcoinindex.url'), $params)['Markets'];

        WorldCoinIndex::truncate();
        foreach ($response as $index => $data){
            WorldCoinIndex::create($data);
        }
    }

}