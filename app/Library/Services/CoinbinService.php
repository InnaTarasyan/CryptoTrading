<?php

namespace App\Library\Services;

use App\Library\Services\Base\BaseService;
use App\Models\Coinbin;

class CoinbinService extends BaseService{

    public function get(){

        $response = $this->retrieveData(config('coinbin.url'), []);

        Coinbin::truncate();
        foreach ($response['coins'] as $index => $data){
            Coinbin::create($data);
        }
    }
}